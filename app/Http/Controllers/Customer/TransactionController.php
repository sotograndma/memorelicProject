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
        $type = $request->query('type'); // Ambil dari query string ?type=item atau ?type=auction

        $auction = null;
        $item = null;

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
            $totalPrice = $item->price;
        } else {
            return redirect()->route('customer.dashboard')->with('error', 'Tipe barang tidak valid.');
        }

        return view('customer.transactions.checkout', [
            'auction' => $auction,
            'item' => $item,
            'totalPrice' => $totalPrice
        ]);
    }

    public function processCheckout(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'type' => 'required|in:item,auction'
        ]);

        // Ambil tipe item
        $type = $request->type;

        // Ambil data berdasarkan tipe
        $auction = null;
        $item = null;

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
            $totalPrice = $item->price;
        }

        // Buat kode pembayaran unik
        $paymentCode = 'PAY-' . strtoupper(substr(md5(time()), 0, 8));

        DB::beginTransaction();
        try {
            // Buat transaksi baru
            $transaction = Transaction::create([
                'customer_id' => $user->id,
                'auction_id' => $auction ? $auction->id : null,
                'item_id' => $item ? $item->id : null,
                'total_price' => $totalPrice,
                'status' => 'waiting_payment',
                'payment_code' => $paymentCode,
                'shipping_address' => $request->shipping_address,
            ]);

            // Jika dari auction, tandai sebagai checkout selesai
            if ($auction) {
                $auction->is_checkout_done = true;
                $auction->status = 'sold';
                $auction->save();
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

        // Perbarui status transaksi menjadi 'completed'
        $transaction->update(['status' => 'completed']);

        // Cek apakah ini transaksi dari item biasa atau auction
        if ($transaction->auction_id) {
            // Jika dari auction, update status auction menjadi sold
            $auction = Auction::findOrFail($transaction->auction_id);
            $auction->status = 'sold';
            $auction->is_checkout_done = true;
            $auction->save();
        } elseif ($transaction->item_id) {
            // Jika dari item biasa, update status item menjadi sold
            $transaction->item->update(['status' => 'sold']);
        }

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
        // Ambil barang yang statusnya 'sold' dan memiliki transaksi
        $soldItems = Item::where('status', 'sold')->with('transactions.customer')->get();

        return view('customer.items.sold_items', compact('soldItems'));
    }
}
