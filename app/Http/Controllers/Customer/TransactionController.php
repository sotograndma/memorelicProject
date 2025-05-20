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
    public function checkout(Request $request, $id)
    {
        $user = Auth::user();
        $type = $request->query('type');
        $quantity = $request->query('quantity', 1);

        $auction = null;
        $item = null;
        $totalPrice = 0;

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
            'totalPrice' => $totalPrice
        ]);
    }

    public function processCheckout(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'type' => 'required|in:item,auction',
            'quantity' => 'nullable|integer|min:1' // jika ingin support beli >1
        ]);

        $type = $request->type;
        $auction = null;
        $item = null;
        $quantity = $request->quantity ?? 1;

        if ($type === 'auction') {
            $auction = Auction::find($id);
            if (!$auction) {
                return redirect()->route('customer.dashboard')->with('error', 'Barang lelang tidak ditemukan.');
            }
            $totalPrice = $auction->highest_bid ?? $auction->starting_bid;
        } else {
            $item = Item::find($id);
            if (!$item) {
                return redirect()->route('customer.dashboard')->with('error', 'Barang tidak ditemukan.');
            }

            // Cek apakah stok cukup
            if ($item->stock < $quantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah yang dipilih.');
            }

            $totalPrice = $item->price * $quantity;
        }

        $paymentCode = 'PAY-' . strtoupper(substr(md5(time()), 0, 8));

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'customer_id' => $user->id,
                'auction_id' => $auction ? $auction->id : null,
                'item_id' => $item ? $item->id : null,
                'total_price' => $totalPrice,
                'quantity' => $quantity,
                'status' => 'waiting_payment',
                'payment_code' => $paymentCode,
                'shipping_address' => $request->shipping_address,
            ]);

            if ($auction) {
                $auction->is_checkout_done = true;
                $auction->status = 'sold';
                $auction->save();
            }

            if ($item) {
                // Kurangi stok
                $item->stock -= $quantity;

                // Jika stok habis, ubah status jadi 'sold'
                if ($item->stock <= 0) {
                    $item->status = 'sold';
                    $item->stock = 0; // pastikan tidak negatif
                }

                $item->save();
            }

            DB::commit();
            return redirect()->route('customer.payment.code', ['transaction_id' => $transaction->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd('GAGAL TRANSAKSI:', $e->getMessage());
            return redirect()->route('customer.dashboard')->with('error', 'Terjadi kesalahan saat checkout.');
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
