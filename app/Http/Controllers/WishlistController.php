<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $customerId = Auth::user()->userable->id;

        $wishlists = Wishlist::with(['item', 'auction'])
            ->where('customer_id', $customerId)
            ->get();

        return view('customer.wishlist', compact('wishlists'));
    }

    public function store(Request $request)
    {
        Wishlist::create([
            'customer_id' => Auth::user()->userable->id,
            'item_id' => $request->item_id,
            'auction_id' => $request->auction_id,
        ]);

        return back()->with('success', 'Ditambahkan ke wishlist');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();

        return back()->with('success', 'Dihapus dari wishlist');
    }
}
