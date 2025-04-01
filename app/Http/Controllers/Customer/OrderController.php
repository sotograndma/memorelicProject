<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class OrderController extends Controller
{
    // Menampilkan semua barang yang tersedia untuk dibeli
    public function index()
    {
        $items = Item::where('status', 'available')->get();
        return view('customer.orders.index', compact('items'));
    }

    // Menampilkan detail barang berdasarkan ID
    public function show($id)
    {
        $item = Item::findOrFail($id); // Ambil data barang berdasarkan ID
        return view('customer.orders.show', compact('item'));
    }
}
