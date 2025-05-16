<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

            // Fields tambahan dari migration
            'condition' => 'nullable|in:Used,Excellent,Brand New,Restored',
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
            'returns_package' => 'nullable|in:30-Day Refund / Replacement,7-Day Refund Only,No Return / Final Sale',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('auctions', 'public');
        }

        $certificateImagePath = null;
        if ($request->hasFile('authenticity_certificate_images')) {
            $certificateImagePath = $request->file('authenticity_certificate_images')->store('certificates', 'public');
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
            
            // Field tambahan
            'condition' => $request->condition,
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
            'returns_package' => $request->returns_package,
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

            'condition' => 'nullable|in:Used,Excellent,Brand New,Restored',
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
            'returns_package' => 'nullable|in:30-Day Refund / Replacement,7-Day Refund Only,No Return / Final Sale',
        ]);

        if ($request->hasFile('image')) {
            if ($auction->image_path) {
                Storage::disk('public')->delete($auction->image_path);
            }
            $auction->image_path = $request->file('image')->store('auctions', 'public');
        }

        if ($request->hasFile('authenticity_certificate_images')) {
            if ($auction->authenticity_certificate_images) {
                Storage::disk('public')->delete($auction->authenticity_certificate_images);
            }
            $auction->authenticity_certificate_images = $request->file('authenticity_certificate_images')->store('certificates', 'public');
        }

        $auction->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'buy_now_price' => $request->buy_now_price,
            'minimum_increment' => $request->minimum_increment,
            'image_path' => $auction->image_path,

            
            'condition' => $request->condition,
            'year_of_origin' => $request->year_of_origin,
            'material' => $request->material,
            'height' => $request->height,
            'width' => $request->width,
            'weight' => $request->weight,
            'region_of_origin' => $request->region_of_origin,
            'maker' => $request->maker,
            'rarity_level' => $request->rarity_level,
            'authenticity_certificate' => $request->authenticity_certificate,
            'authenticity_certificate_images' => $auction->authenticity_certificate_images,
            'restoration_info' => $request->restoration_info,
            'provenance' => $request->provenance,
            'category' => $request->category,
            'damage_notes' => $request->damage_notes,
            'shipping_locations' => $request->shipping_locations,
            'shipping_cost' => $request->shipping_cost,
            'returns_package' => $request->returns_package,
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
