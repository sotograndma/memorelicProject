<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'condition' => 'nullable|in:Used,Excellent,Brand New,Restored',
            'min_order' => 'nullable|integer|min:1',
            'year_of_origin' => 'nullable|date',
            'material' => 'nullable|string',
            'height' => 'nullable|string',
            'width' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'region_of_origin' => 'nullable|string',
            'maker' => 'nullable|string',
            'rarity_level' => 'nullable|in:Common,Rare,Very Rare',
            'authenticity_certificate' => 'nullable|in:Yes,No,Under verification',
            'authenticity_certificate_images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'restoration_info' => 'nullable|string',
            'provenance' => 'nullable|string',
            'category' => 'nullable|in:Collectibles,Accessories,Traditional Weapons,Electronics,Furniture',
            'damage_notes' => 'nullable|string',
            'shipping_locations' => 'nullable|string',
            'shipping_cost' => [
                'nullable',
                Rule::in([
                    'Regular Shipping (0–1 kg) | from Rp6.500 | ETA: 2–3 days',
                    'Medium Package (1–3 kg) | from Rp12.000 | ETA: 2–4 days',
                    'Heavy Shipping (3–5 kg) | from Rp20.000 | ETA: 3–5 days',
                ])
            ],
            'stock' => 'nullable|integer|min:1',
            'returns_package' => 'nullable|in:30-Day Refund / Replacement,7-Day Refund Only,No Return / Final Sale',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $certificateImagePath = null;
        if ($request->hasFile('authenticity_certificate_images')) {
            $certificateImagePath = $request->file('authenticity_certificate_images')->store('certificates', 'public');
        }


        Item::create([
            'customers_id' => $user->userable_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => 'available',
            'image_path' => $imagePath,

            // Field tambahan
            'condition' => $request->condition,
            'min_order' => $request->min_order,
            'year_of_origin' => $request->year_of_origin,
            'material' => $request->material,
            'height' => $request->height,
            'width' => $request->width,
            'weight' => $request->weight,
            'region_of_origin' => $request->region_of_origin,
            'maker' => $request->maker,
            'rarity_level' => $request->rarity_level,
            'authenticity_certificate' => $request->authenticity_certificate,
            'authenticity_certificate_images' => $certificateImagePath,
            'restoration_info' => $request->restoration_info,
            'provenance' => $request->provenance,
            'category' => $request->category,
            'damage_notes' => $request->damage_notes,
            'shipping_locations' => $request->shipping_locations,
            'shipping_cost' => $request->shipping_cost,
            'stock' => $request->stock ?? 1,
            'returns_package' => $request->returns_package,
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
            
            'condition' => 'nullable|in:Used,Excellent,Brand New,Restored',
            'min_order' => 'nullable|integer|min:1',
            'year_of_origin' => 'nullable|date',
            'material' => 'nullable|string',
            'height' => 'nullable|string',
            'width' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'region_of_origin' => 'nullable|string',
            'maker' => 'nullable|string',
            'rarity_level' => 'nullable|in:Common,Rare,Very Rare',
            'authenticity_certificate' => 'nullable|in:Yes,No,Under verification',
            'authenticity_certificate_images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'restoration_info' => 'nullable|string',
            'provenance' => 'nullable|string',
            'category' => 'nullable|in:Collectibles,Accessories,Traditional Weapons,Electronics,Furniture',
            'damage_notes' => 'nullable|string',
            'shipping_locations' => 'nullable|string',
            'shipping_cost' => [
                'nullable',
                Rule::in([
                    'Regular Shipping (0–1 kg) | from Rp6.500 | ETA: 2–3 days',
                    'Medium Package (1–3 kg) | from Rp12.000 | ETA: 2–4 days',
                    'Heavy Shipping (3–5 kg) | from Rp20.000 | ETA: 3–5 days',
                ])
            ],
            'stock' => 'nullable|integer|min:1',
            'returns_package' => 'nullable|in:30-Day Refund / Replacement,7-Day Refund Only,No Return / Final Sale',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $item->image_path = $request->file('image')->store('items', 'public');
        }

        if ($request->hasFile('authenticity_certificate_images')) {
            if ($item->authenticity_certificate_images) {
                Storage::disk('public')->delete($item->authenticity_certificate_images);
            }
            $item->authenticity_certificate_images = $request->file('authenticity_certificate_images')->store('certificates', 'public');
        }

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $item->image_path,

            'condition' => $request->condition,
            'min_order' => $request->min_order,
            'year_of_origin' => $request->year_of_origin,
            'material' => $request->material,
            'height' => $request->height,
            'width' => $request->width,
            'weight' => $request->weight,
            'region_of_origin' => $request->region_of_origin,
            'maker' => $request->maker,
            'rarity_level' => $request->rarity_level,
            'authenticity_certificate' => $request->authenticity_certificate,
            'authenticity_certificate_images' => $item->authenticity_certificate_images,
            'restoration_info' => $request->restoration_info,
            'provenance' => $request->provenance,
            'category' => $request->category,
            'damage_notes' => $request->damage_notes,
            'shipping_locations' => $request->shipping_locations,
            'shipping_cost' => $request->shipping_cost,
            'stock' => $request->stock,
            'returns_package' => $request->returns_package,
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
