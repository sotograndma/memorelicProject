@extends('customer.sidebar')

@section('content')

<div class="d-flex flex-column">
    <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
        <div>
            <p style="font-weight: bold !important" class="font-bold">Edit Barang</p>
            <p class="mb-4">Perbarui detail barang Anda di bawah ini.</p>

            @if ($errors->any())
                <div class="bg-red-500 text-white p-2 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customer.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Barang</label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Deskripsi</label>
                    <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required>{{ old('description', $item->description) }}</textarea>
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $item->price) }}" class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                {{-- Gambar --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Gambar Saat Ini</label>
                    @if ($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="Gambar {{ $item->name }}" width="150" class="mb-2">
                    @endif
                    <input type="file" name="image" class="w-full border p-2 rounded">
                </div>

                {{-- Kondisi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Kondisi</label>
                    <select name="condition" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Kondisi --</option>
                        @foreach (['Used', 'Excellent', 'Brand New', 'Restored'] as $option)
                            <option value="{{ $option }}" {{ old('condition', $item->condition) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Upload Sertifikat --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Upload Sertifikat Keaslian</label>
                    @if ($item->authenticity_certificate_images)
                        <img src="{{ asset('storage/' . $item->authenticity_certificate_images) }}" alt="Sertifikat" width="150" class="mb-2">
                    @endif
                    <input type="file" name="authenticity_certificate_images" class="w-full border p-2 rounded">
                </div>

                {{-- Kategori --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Kategori</label>
                    <select name="category" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach (['Collectibles', 'Accessories', 'Traditional Weapons', 'Electronics', 'Furniture'] as $option)
                            <option value="{{ $option }}" {{ old('category', $item->category) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tingkat Kelangkaan --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Tingkat Kelangkaan</label>
                    <select name="rarity_level" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Tingkat --</option>
                        @foreach (['Common', 'Rare', 'Very Rare'] as $option)
                            <option value="{{ $option }}" {{ old('rarity_level', $item->rarity_level) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sertifikat Keaslian --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Sertifikat Keaslian</label>
                    <select name="authenticity_certificate" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Status --</option>
                        @foreach (['Yes', 'No', 'Under verification'] as $option)
                            <option value="{{ $option }}" {{ old('authenticity_certificate', $item->authenticity_certificate) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Info Restorasi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Informasi Restorasi</label>
                    <input type="text" name="restoration_info" value="{{ old('restoration_info', $item->restoration_info) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Provenance --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Riwayat Kepemilikan (Provenance)</label>
                    <textarea name="provenance" class="w-full p-2 border border-gray-300 rounded">{{ old('provenance', $item->provenance) }}</textarea>
                </div>

                {{-- Min Order --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Minimal Order</label>
                    <input type="number" name="min_order" value="{{ old('min_order', $item->min_order) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Tahun Pembuatan --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Tahun Pembuatan</label>
                    <input type="date" name="year_of_origin" value="{{ old('year_of_origin', $item->year_of_origin ? \Carbon\Carbon::parse($item->year_of_origin)->format('Y-m-d') : '') }}" class="w-full border p-2 rounded">
                </div>

                {{-- Material --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Material</label>
                    <input type="text" name="material" value="{{ old('material', $item->material) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Dimensi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Tinggi (cm)</label>
                    <input type="text" name="height" value="{{ old('height', $item->height) }}" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Lebar (cm)</label>
                    <input type="text" name="width" value="{{ old('width', $item->width) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Berat --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Berat (kg)</label>
                    <input type="text" name="weight" value="{{ old('weight', $item->weight) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Asal Wilayah --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Wilayah / Negara Asal</label>
                    <input type="text" name="region_of_origin" value="{{ old('region_of_origin', $item->region_of_origin) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Pembuat --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Pembuat / Pengrajin</label>
                    <input type="text" name="maker" value="{{ old('maker', $item->maker) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Catatan Kerusakan --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Catatan Kerusakan</label>
                    <textarea name="damage_notes" class="w-full p-2 border border-gray-300 rounded">{{ old('damage_notes', $item->damage_notes) }}</textarea>
                </div>

                {{-- Lokasi Pengiriman --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Lokasi Pengiriman</label>
                    <input type="text" name="shipping_locations" value="{{ old('shipping_locations', $item->shipping_locations) }}" class="w-full border p-2 rounded">
                </div>

                {{-- Biaya Pengiriman --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Opsi Pengiriman</label>
                    <select name="shipping_cost" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Opsi --</option>
                        @foreach ([
                            'Regular Shipping (0–1 kg) | from Rp6.500 | ETA: 2–3 days',
                            'Medium Package (1–3 kg) | from Rp12.000 | ETA: 2–4 days',
                            'Heavy Shipping (3–5 kg) | from Rp20.000 | ETA: 3–5 days'
                        ] as $option)
                            <option value="{{ $option }}" {{ old('shipping_cost', $item->shipping_cost) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Stok --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Stok Barang</label>
                    <input type="number" name="stock" value="{{ old('stock', $item->stock) }}" class="w-full border p-2 rounded" min="1">
                </div>

                {{-- Return Policy --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Kebijakan Pengembalian</label>
                    <select name="returns_package" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Kebijakan --</option>
                        @foreach ([
                            '30-Day Refund / Replacement',
                            '7-Day Refund Only',
                            'No Return / Final Sale'
                        ] as $option)
                            <option value="{{ $option }}" {{ old('returns_package', $item->returns_package) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol --}}
                <button type="submit" class="btn btn-warning">Update Barang</button>
            </form>
        </div>
    </div>
</div>

@endsection
