<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'customer' || !$user->userable_id) {
            return redirect()->route('customer.items.index')->with('error', 'Anda bukan customer yang valid.');
        }

        // Hanya menampilkan barang milik user yang statusnya masih available
        $items = Item::where('customers_id', $user->userable_id)
            ->where('status', 'available')
            ->get();

        return view('customer.items.index', compact('items'));
    }


    public function create()
    {
        return view('customer.items.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'customer' || !$user->userable_id) {
            return redirect()->route('customer.items.index')->with('error', 'Anda bukan customer yang valid.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'customers_id' => $user->userable_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => 'available',
            'image_path' => $imagePath,
        ]);

        return redirect()->route('customer.items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Item $item)
    {
        $user = Auth::user();
        if ($item->customers_id !== $user->userable_id) {
            abort(403);
        }

        return view('customer.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $user = Auth::user();
        if ($item->customers_id !== $user->userable_id) {
            abort(403);
        }

        return view('customer.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $user = Auth::user();
        if ($item->customers_id !== $user->userable_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $item->image_path = $request->file('image')->store('items', 'public');
        }

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $item->image_path,
        ]);

        return redirect()->route('customer.items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $user = Auth::user();
        if ($item->customers_id !== $user->userable_id) {
            abort(403);
        }

        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();
        return redirect()->route('customer.items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
