@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                <p style="font-weight: bold !important" class="font-bold">Edit Lelang</p>
                <p class="mb-4">Perbarui informasi barang antik Anda.</p>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-2 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customer.auctions.update', $auction->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Barang</label>
                        <input type="text" name="name" value="{{ old('name', $auction->name) }}" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required>{{ old('description', $auction->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga Awal (Rp)</label>
                        <input type="number" name="starting_bid" value="{{ old('starting_bid', $auction->starting_bid) }}" class="w-full p-2 border border-gray-300 rounded" required disabled>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga Beli Sekarang (Rp)</label>
                        <input type="number" name="buy_now_price" value="{{ old('buy_now_price', $auction->buy_now_price) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Minimum Incremental Bid (Rp)</label>
                        <input type="number" name="minimum_increment" value="{{ old('minimum_increment', $auction->minimum_increment) }}" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" value="{{ old('start_time', date('Y-m-d\TH:i', strtotime($auction->start_time))) }}" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Waktu Berakhir</label>
                        <input type="datetime-local" name="end_time" value="{{ old('end_time', date('Y-m-d\TH:i', strtotime($auction->end_time))) }}" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Gambar Saat Ini</label><br>
                        @if ($auction->image_path)
                            <img src="{{ asset('storage/' . $auction->image_path) }}" width="150" class="mb-2">
                        @endif
                        <input type="file" name="image" class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Kondisi</label>
                        <select name="condition" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            @foreach(['Used','Excellent','Brand New','Restored'] as $val)
                                <option value="{{ $val }}" {{ old('condition', $auction->condition) === $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tahun Pembuatan</label>
                        <input type="date" name="year_of_origin" value="{{ old('year_of_origin', date('Y-m-d', strtotime($auction->year_of_origin))) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Material</label>
                        <input type="text" name="material" value="{{ old('material', $auction->material) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Tinggi</label>
                            <input type="text" name="height" value="{{ old('height', $auction->height) }}" class="w-full p-2 border border-gray-300 rounded">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Lebar</label>
                            <input type="text" name="width" value="{{ old('width', $auction->width) }}" class="w-full p-2 border border-gray-300 rounded">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Berat (kg)</label>
                        <input type="number" step="0.01" name="weight" value="{{ old('weight', $auction->weight) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Asal Daerah</label>
                        <input type="text" name="region_of_origin" value="{{ old('region_of_origin', $auction->region_of_origin) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Pembuat</label>
                        <input type="text" name="maker" value="{{ old('maker', $auction->maker) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tingkat Kelangkaan</label>
                        <select name="rarity_level" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            @foreach(['Common','Rare','Very Rare'] as $val)
                                <option value="{{ $val }}" {{ old('rarity_level', $auction->rarity_level) === $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Sertifikat Keaslian</label>
                        <select name="authenticity_certificate" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            @foreach(['Yes','No','Under verification'] as $val)
                                <option value="{{ $val }}" {{ old('authenticity_certificate', $auction->authenticity_certificate) === $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Sertifikat Saat Ini</label><br>
                        @if ($auction->authenticity_certificate_images)
                            <img src="{{ asset('storage/' . $auction->authenticity_certificate_images) }}" width="150" class="mb-2">
                        @endif
                        <input type="file" name="authenticity_certificate_images" class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Info Restorasi</label>
                        <input type="text" name="restoration_info" value="{{ old('restoration_info', $auction->restoration_info) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Riwayat Kepemilikan</label>
                        <textarea name="provenance" class="w-full p-2 border border-gray-300 rounded">{{ old('provenance', $auction->provenance) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Kategori</label>
                        <select name="category" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            @foreach(['Collectibles','Accessories','Traditional Weapons','Electronics','Furniture'] as $val)
                                <option value="{{ $val }}" {{ old('category', $auction->category) === $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Catatan Kerusakan</label>
                        <textarea name="damage_notes" class="w-full p-2 border border-gray-300 rounded">{{ old('damage_notes', $auction->damage_notes) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Lokasi Pengiriman</label>
                        <input type="text" name="shipping_locations" value="{{ old('shipping_locations', $auction->shipping_locations) }}" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jenis Pengiriman</label>
                        <select name="shipping_cost" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            @foreach([
                                'Regular Shipping (0–1 kg) | from Rp6.500 | ETA: 2–3 days',
                                'Medium Package (1–3 kg) | from Rp12.000 | ETA: 2–4 days',
                                'Heavy Shipping (3–5 kg) | from Rp20.000 | ETA: 3–5 days'
                            ] as $val)
                                <option value="{{ $val }}" {{ old('shipping_cost', $auction->shipping_cost) === $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Kebijakan Retur</label>
                        <select name="returns_package" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            @foreach([
                                '30-Day Refund / Replacement',
                                '7-Day Refund Only',
                                'No Return / Final Sale'
                            ] as $val)
                                <option value="{{ $val }}" {{ old('returns_package', $auction->returns_package) === $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning">Update Barang</button>
                </form>
            </div>
        </div>
    </div>
@endsection
