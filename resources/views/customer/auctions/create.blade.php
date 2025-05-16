@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                <p style="font-weight: bold !important" class="font-bold">Lelang Barang Baru</p>
                <p class="mb-4">Lengkapi informasi barang antik yang akan Anda lelang.</p>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-2 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customer.auctions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Barang</label>
                        <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga Awal (Rp)</label>
                        <input type="number" name="starting_bid" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga Beli Sekarang (Rp) <span class="text-gray-500">(Opsional)</span></label>
                        <input type="number" name="buy_now_price" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Minimum Incremental Bid (Rp)</label>
                        <input type="number" name="minimum_increment" class="w-full p-2 border border-gray-300 rounded" value="5000" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Waktu Berakhir</label>
                        <input type="datetime-local" name="end_time" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Upload Gambar</label>
                        <input type="file" name="image" class="w-full border p-2 rounded">
                    </div>

                    {{-- FIELD TAMBAHAN --}}
                    <div class="mb-4">
                        <label class="block text-gray-700">Kondisi Barang</label>
                        <select name="condition" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            <option value="Used">Used</option>
                            <option value="Excellent">Excellent</option>
                            <option value="Brand New">Brand New</option>
                            <option value="Restored">Restored</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tahun Pembuatan</label>
                        <input type="date" name="year_of_origin" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Material</label>
                        <input type="text" name="material" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700">Tinggi (cm)</label>
                            <input type="text" name="height" class="w-full p-2 border border-gray-300 rounded">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Lebar (cm)</label>
                            <input type="text" name="width" class="w-full p-2 border border-gray-300 rounded">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Berat (kg)</label>
                        <input type="number" step="0.01" name="weight" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Asal Daerah</label>
                        <input type="text" name="region_of_origin" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Pembuat</label>
                        <input type="text" name="maker" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tingkat Kelangkaan</label>
                        <select name="rarity_level" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            <option value="Common">Common</option>
                            <option value="Rare">Rare</option>
                            <option value="Very Rare">Very Rare</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Sertifikat Keaslian</label>
                        <select name="authenticity_certificate" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Under verification">Under verification</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Upload Sertifikat Keaslian</label>
                        <input type="file" name="authenticity_certificate_images" class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Informasi Restorasi</label>
                        <input type="text" name="restoration_info" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Provenance / Riwayat Kepemilikan</label>
                        <textarea name="provenance" class="w-full p-2 border border-gray-300 rounded"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Kategori Barang</label>
                        <select name="category" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            <option value="Collectibles">Collectibles</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Traditional Weapons">Traditional Weapons</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Furniture">Furniture</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Catatan Kerusakan (Opsional)</label>
                        <textarea name="damage_notes" class="w-full p-2 border border-gray-300 rounded"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Lokasi Pengiriman</label>
                        <input type="text" name="shipping_locations" class="w-full p-2 border border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Pilihan Pengiriman</label>
                        <select name="shipping_cost" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            <option value="Regular Shipping (0–1 kg) | from Rp6.500 | ETA: 2–3 days">Regular Shipping (0–1 kg)</option>
                            <option value="Medium Package (1–3 kg) | from Rp12.000 | ETA: 2–4 days">Medium Package (1–3 kg)</option>
                            <option value="Heavy Shipping (3–5 kg) | from Rp20.000 | ETA: 3–5 days">Heavy Shipping (3–5 kg)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Kebijakan Retur</label>
                        <select name="returns_package" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Pilih --</option>
                            <option value="30-Day Refund / Replacement">30-Day Refund / Replacement</option>
                            <option value="7-Day Refund Only">7-Day Refund Only</option>
                            <option value="No Return / Final Sale">No Return / Final Sale</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Jual Barang</button>
                </form>
            </div>
        </div>
    </div>
@endsection
