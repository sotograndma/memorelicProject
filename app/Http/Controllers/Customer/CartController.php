<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart($id)
    {
        $item = Item::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $item->name,
                'price' => $item->price,
                'image' => $item->image_path,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('customer.cart.view')->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('customer.transactions.cart', compact('cart', 'total'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    public function checkoutCart()
    {
        $cart = session()->get('cart', []);
        session()->put('cart_items', $cart); // kirim ke session, bukan with()
        return redirect()->route('customer.checkout.cart');
    }
}
