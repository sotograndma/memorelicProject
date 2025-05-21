<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Auction;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Halaman Checkout
    public function checkout(Request $request, $id = null)
    {
        $user = Auth::user();
        $type = $request->query('type');
        $quantity = $request->query('quantity', 1);

        $auction = null;
        $item = null;
        $totalPrice = 0;
        $items = [];

        // Cek jika ada cart session
        if (session()->has('cart_items')) {
            $cart = session()->get('cart_items');
            $items = [];
            $totalPrice = 0;

            foreach ($cart as $itemId => $cartItem) {
                $foundItem = \App\Models\Item::find($itemId);
                if ($foundItem) {
                    $items[] = [
                        'model' => $foundItem,
                        'quantity' => $cartItem['quantity'],
                        'subtotal' => $foundItem->price * $cartItem['quantity'],
                    ];
                    $totalPrice += $foundItem->price * $cartItem['quantity'];
                }
            }

            return view('customer.transactions.checkout', [
                'items' => $items,
                'totalPrice' => $totalPrice,
                'fromCart' => true,
            ]);
        }

        // Jika bukan dari keranjang
        if ($type === 'auction') {
            $auction = Auction::find($id);
            if (!$auction) {
                return redirect()->route('customer.dashboard')->with('error', 'Barang lelang tidak ditemukan.');
            }
            $totalPrice = $auction->highest_bid ?? $auction->starting_bid;
        } elseif ($type === 'item') {
            $item = Item::find($id);
            if (!$item) {
                return redirect()->route('customer.dashboard')->with('error', 'Barang tidak ditemukan.');
            }
            $totalPrice = $item->price * $quantity;
        } else {
            return redirect()->route('customer.dashboard')->with('error', 'Tipe barang tidak valid.');
        }

        return view('customer.transactions.checkout', [
            'auction' => $auction,
            'item' => $item,
            'quantity' => $quantity,
            'totalPrice' => $totalPrice,
            'fromCart' => false,
        ]);
    }


    public function processCheckout(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'type' => 'required|in:item,auction,cart',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $type = $request->type;
        $quantity = $request->quantity ?? 1;
        $paymentCode = 'PAY-' . strtoupper(substr(md5(time()), 0, 8));

        DB::beginTransaction();
        try {
            // === Jika checkout dari CART ===
            if ($type === 'cart') {
                $cart = session()->get('cart', []);
                if (empty($cart)) {
                    return redirect()->route('customer.cart.view')->with('error', 'Keranjang kosong.');
                }

                $transactionIds = [];

                foreach ($cart as $itemId => $cartItem) {
                    $item = Item::find($itemId);

                    if (!$item) continue;

                    $qty = $cartItem['quantity'];
                    $totalPrice = $item->price * $qty;

                    // Cek stok
                    if ($item->stock < $qty) {
                        DB::rollBack();
                        return redirect()->route('customer.cart.view')->with('error', 'Stok tidak cukup untuk: ' . $item->name);
                    }

                    // Simpan transaksi
                    $transaction = Transaction::create([
                        'customer_id' => $user->id,
                        'item_id' => $item->id,
                        'total_price' => $totalPrice,
                        'quantity' => $qty,
                        'status' => 'waiting_payment',
                        'payment_code' => $paymentCode,
                        'shipping_address' => $request->shipping_address,
                    ]);

                    $transactionIds[] = $transaction->id;

                    // Update stok
                    $item->stock -= $qty;
                    if ($item->stock <= 0) {
                        $item->stock = 0;
                        $item->status = 'sold';
                    }
                    $item->save();
                }

                // Hapus keranjang setelah checkout berhasil
                
                session()->forget('cart');
                session()->forget('cart_items');

                DB::commit();
                return redirect()->route('customer.payment.code', ['transaction_id' => implode(',', $transactionIds)]);
            }

            // === Jika checkout satuan (item atau auction) ===
            $auction = null;
            $item = null;
            $totalPrice = 0;

            if ($type === 'auction') {
                $auction = Auction::find($id);
                if (!$auction) {
                    return redirect()->route('customer.dashboard')->with('error', 'Barang lelang tidak ditemukan.');
                }

                $totalPrice = $auction->highest_bid ?? $auction->starting_bid;

                Transaction::create([
                    'customer_id' => $user->id,
                    'auction_id' => $auction->id,
                    'total_price' => $totalPrice,
                    'quantity' => 1,
                    'status' => 'waiting_payment',
                    'payment_code' => $paymentCode,
                    'shipping_address' => $request->shipping_address,
                ]);

                $auction->update([
                    'is_checkout_done' => true,
                    'status' => 'sold',
                ]);
            } elseif ($type === 'item') {
                $item = Item::find($id);
                if (!$item) {
                    return redirect()->route('customer.dashboard')->with('error', 'Barang tidak ditemukan.');
                }

                if ($item->stock < $quantity) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah yang dipilih.');
                }

                $totalPrice = $item->price * $quantity;

                Transaction::create([
                    'customer_id' => $user->id,
                    'item_id' => $item->id,
                    'total_price' => $totalPrice,
                    'quantity' => $quantity,
                    'status' => 'waiting_payment',
                    'payment_code' => $paymentCode,
                    'shipping_address' => $request->shipping_address,
                ]);

                $item->stock -= $quantity;
                if ($item->stock <= 0) {
                    $item->status = 'sold';
                    $item->stock = 0;
                }
                $item->save();
            }

            DB::commit();

            // Untuk transaksi satuan, redirect ke halaman kode pembayaran
            if ($type !== 'cart') {
                $transaction = Transaction::latest()->where('customer_id', $user->id)->first();
                return redirect()->route('customer.payment.code', ['transaction_id' => $transaction->id]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.cart.view')->with('error', 'Gagal saat proses checkout: ' . $e->getMessage());
        }
    }


    // Halaman Kode Pembayaran
    public function paymentCode($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);
        return view('customer.transactions.payment_code', compact('transaction'));
    }

    // Halaman Proses Pembayaran
    public function paymentProcess($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);
        return view('customer.transactions.payment_process', compact('transaction'));
    }

    // Halaman Payment Completed
    public function paymentCompleted($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);

        // Hanya ubah ke processing jika status masih waiting_payment
        if ($transaction->status === 'waiting_payment') {
            $transaction->update(['status' => 'processing']);
        }

        if ($transaction->item_id) {
            $item = $transaction->item;
            $item->sold_count += $transaction->quantity;
            $item->save();
        }

        if ($transaction->auction_id) {
            $auction = Auction::findOrFail($transaction->auction_id);
            $auction->status = 'sold';
            $auction->is_checkout_done = true;
            $auction->save();
        } elseif ($transaction->item_id) {
            $item = Item::findOrFail($transaction->item_id);
            if ($item->stock <= 0 && $item->status != 'sold') {
                $item->status = 'sold';
                $item->save();
            }
        }

        // Kirim ke view dengan modal jika session review_submitted ada
        return view('customer.transactions.payment_completed', compact('transaction'));
    }

    // Halaman Riwayat Transaksi
    public function transactionHistory(Request $request)
    {
        $status = $request->query('status', 'all');

        // Ambil transaksi dengan item atau auction
        $query = Transaction::where('customer_id', Auth::user()->id)->with(['item', 'auction']);

        // Jangan filter status jika 'all', agar semua transaksi ditampilkan
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $transactions = $query->get();

        if ($transactions->isEmpty()) {
            return view('customer.transactions.index', compact('transactions'))->with('error', 'Tidak ada transaksi yang ditemukan.');
        }

        return view('customer.transactions.index', compact('transactions'));
    }

    // Halaman Barang Terjual untuk Penjual
    public function soldItems()
    {
        $user = Auth::user();

        // Barang biasa milik penjual (customer)
        $soldItems = Item::where('customers_id', $user->userable_id)
            ->whereHas('transactions', function ($query) {
                $query->where('status', 'completed');
            })
            ->with(['transactions' => function ($q) {
                $q->where('status', 'completed')->with('customer');
            }])
            ->get();

        // Barang lelang milik penjual (customer)
        $soldAuctions = Auction::where('customers_id', $user->userable_id)
            ->where('status', 'sold')
            ->where('is_checkout_done', true)
            ->with(['transaction.customer']) // relasi tunggal
            ->get();

        return view('customer.items.sold_items', compact('soldItems', 'soldAuctions'));
    }

    // Halaman untuk penjual melihat transaksi processing
    public function manageShipping()
    {
        $user = Auth::user();

        $transactions = Transaction::whereIn('status', ['processing', 'shipping_in_progress'])
            ->where(function ($query) use ($user) {
                $query->whereHas('item', function ($q) use ($user) {
                    $q->where('customers_id', $user->userable_id);
                })->orWhereHas('auction', function ($q) use ($user) {
                    $q->where('customers_id', $user->userable_id);
                });
            })
            ->with(['item', 'auction', 'customer'])
            ->get();

        return view('customer.transactions.manage', compact('transactions'));
    }

    // Mengupdate status transaksi (shipped / failed)
    public function updateShippingStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'status' => 'required|in:shipping_in_progress,shipped,failed',
            'failure_reason' => 'nullable|string|max:255',
        ]);

        if ($request->status == 'failed') {
            if (!$request->filled('failure_reason')) {
                return back()->with('error', 'Alasan harus diisi untuk status gagal.');
            }
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => $request->failure_reason,
            ]);
        } elseif ($request->status == 'shipping_in_progress') {
            $transaction->update([
                'status' => 'shipping_in_progress',
            ]);
        } elseif ($request->status == 'shipped') {
            $transaction->update([
                'status' => 'shipped',
            ]);
        }

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function confirmReceived(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'shipped') {
            return back()->with('error', 'Transaksi belum dapat dikonfirmasi.');
        }

        $transaction->update([
            'status' => 'waiting_review'
        ]);

        return response()->json(['success' => true]);
    }


}
