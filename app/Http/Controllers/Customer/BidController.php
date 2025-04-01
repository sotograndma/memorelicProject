<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bid;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    // Menampilkan semua barang lelang yang tersedia
    public function index()
    {
        $auctions = Auction::where('status', 'ongoing')->get();
        return view('customer.bids.index', compact('auctions'));
    }

    // Menampilkan detail lelang berdasarkan ID
    public function show($id)
    {
        $auction = Auction::findOrFail($id);
        return view('customer.bids.show', compact('auction'));
    }

    public function create(Auction $auction)
    {
        return view('customer.bids.create', compact('auction'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'bid_amount' => 'required|numeric|min:0',
        ]);

        $auction = Auction::findOrFail($request->auction_id);

        // Pastikan lelang masih berlangsung
        if ($auction->status !== 'ongoing') {
            return redirect()->route('customer.auctions.show', $auction->id)->with('error', 'Lelang sudah berakhir.');
        }

        // Hitung minimal bid baru
        $minimumBid = $auction->highest_bid + $auction->minimum_increment;

        // Validasi apakah bid memenuhi syarat
        if ($request->bid_amount < $minimumBid) {
            return redirect()->route('customer.bids.create', $auction->id)
                ->with('error', 'Bid minimal harus lebih dari Rp ' . number_format($minimumBid, 0, ',', '.'));
        }

        DB::beginTransaction();
        try {
            // Tandai bid sebelumnya sebagai bukan tertinggi lagi
            Bid::where('auction_id', $auction->id)->update(['is_highest' => false]);

            // Simpan bid baru
            $bid = Bid::create([
                'auction_id'  => $auction->id,
                'customer_id' => $user->userable_id,
                'bid_amount'  => $request->bid_amount,
                'is_highest'  => true, // Bid ini menjadi tertinggi
            ]);

            // Perbarui data lelang dengan bid tertinggi
            $auction->highest_bid = $bid->bid_amount;
            $auction->highest_bidder_id = $user->userable_id;

            // Jika bid >= harga langsung beli, langsung checkout
            if ($bid->bid_amount >= $auction->buy_now_price) {
                $auction->status = 'sold';
                $auction->is_checkout_done = true;
                $auction->save();
                DB::commit();
                return redirect()->route('customer.checkout', $auction->id)
                    ->with('success', 'Anda berhasil membeli barang ini! Silakan lanjut ke checkout.');
            }

            $auction->save();
            DB::commit();

            return redirect()->route('customer.bids.index')->with('success', 'Bid berhasil diajukan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.bids.create', $auction->id)
                ->with('error', 'Terjadi kesalahan saat mengajukan bid.');
        }
    }


    public function list()
    {
        $user = Auth::user();

        // Ambil semua bid user yang pernah dilakukan, dengan data lelangnya
        $bids = Bid::with('auction')
            ->where('customer_id', $user->userable_id)
            ->orderByDesc('created_at')
            ->get();

        return view('customer.bids.list', compact('bids'));
    }
}
