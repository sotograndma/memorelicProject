<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuctionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'customer' || !$user->userable_id) {
            return redirect()->route('customer.auctions.index')->with('error', 'Anda bukan customer yang valid.');
        }

        // Hanya menampilkan lelang yang statusnya "ongoing" (belum terjual atau selesai)
        $auctions = Auction::where('status', 'ongoing')
            ->where('is_checkout_done', false)
            ->orderByDesc('created_at')
            ->get();

        $auctions = Auction::where('customers_id', $user->userable_id)->get();
        return view('customer.auctions.index', compact('auctions'));
    }

    public function create()
    {
        return view('customer.auctions.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'customer' || !$user->userable_id) {
            return redirect()->route('customer.auctions.index')->with('error', 'Anda bukan customer yang valid.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_bid' => 'required|numeric|min:1',
            'buy_now_price' => 'nullable|numeric|min:1',
            'minimum_increment' => 'required|numeric|min:5000',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('auctions', 'public');
        }

        Auction::create([
            'customers_id' => $user->userable_id,
            'name' => $request->name,
            'description' => $request->description,
            'starting_bid' => $request->starting_bid,
            'buy_now_price' => $request->buy_now_price,
            'minimum_increment' => $request->minimum_increment,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'ongoing',
            'image_path' => $imagePath,
        ]);

        return redirect()->route('customer.auctions.index')->with('success', 'Lelang berhasil dibuat.');
    }

    public function show(Auction $auction)
    {
        $user = Auth::user();
        if ($auction->customers_id !== $user->userable_id) {
            abort(403);
        }

        return view('customer.auctions.show', compact('auction'));
    }

    public function edit(Auction $auction)
    {
        $user = Auth::user();
        if ($auction->customers_id !== $user->userable_id) {
            abort(403);
        }

        return view('customer.auctions.edit', compact('auction'));
    }

    public function update(Request $request, Auction $auction)
    {
        $user = Auth::user();
        if ($auction->customers_id !== $user->userable_id) {
            abort(403);
        }

        $request->validate([
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'buy_now_price' => 'nullable|numeric|min:1',
            'minimum_increment' => 'required|numeric|min:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($auction->image_path) {
                Storage::disk('public')->delete($auction->image_path);
            }
            $auction->image_path = $request->file('image')->store('auctions', 'public');
        }

        $auction->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'buy_now_price' => $request->buy_now_price,
            'minimum_increment' => $request->minimum_increment,
            'image_path' => $auction->image_path,
        ]);

        return redirect()->route('customer.auctions.index')->with('success', 'Lelang berhasil diperbarui.');
    }

    public function destroy(Auction $auction)
    {
        $user = Auth::user();
        if ($auction->customers_id !== $user->userable_id) {
            abort(403);
        }

        if ($auction->image_path) {
            Storage::disk('public')->delete($auction->image_path);
        }

        $auction->delete();
        return redirect()->route('customer.auctions.index')->with('success', 'Lelang berhasil dihapus.');
    }
}
