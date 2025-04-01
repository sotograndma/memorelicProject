<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $orders = Order::with(['customer', 'item'])->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with(['customer', 'item', 'shipment'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // Membuat pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'item_id' => 'required|exists:items,id',
            'payment_status' => 'required|in:pending,paid,failed',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|in:bank_transfer,e-wallet,installments',
        ]);

        $order = Order::create($request->all());

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat.');
    }

    // Mengupdate status pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return redirect()->route('orders.show', $id)->with('success', 'Status pesanan diperbarui.');
    }

    // Menghapus pesanan
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
