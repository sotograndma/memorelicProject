@extends('customer.sidebar')

@section('content')

<div class="d-flex flex-column">
    <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
        <div>
            <p style="font-weight: bold !important" class="font-bold">Jual Barang</p>
            <p class="mb-4">Lengkapi detail barang antik yang ingin Anda jual.</p>

            @if ($errors->any())
                <div class="bg-red-500 text-white p-2 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customer.items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Barang</label>
                    <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Deskripsi</label>
                    <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required></textarea>
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Harga (Rp)</label>
                    <input type="number" name="price" class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                {{-- Upload Gambar --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Upload Gambar</label>
                    <input type="file" name="image" class="w-full border p-2 rounded">
                </div>

                {{-- Kondisi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Kondisi</label>
                    <select name="condition" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Used">Used</option>
                        <option value="Excellent">Excellent</option>
                        <option value="Brand New">Brand New</option>
                        <option value="Restored">Restored</option>
                    </select>
                </div>

                {{-- Minimal Order --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Minimal Order</label>
                    <input type="number" name="min_order" class="w-full border p-2 rounded">
                </div>

                {{-- Tahun Pembuatan --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Tahun Pembuatan</label>
                    <input type="date" name="year_of_origin" class="w-full border p-2 rounded">
                </div>

                {{-- Material --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Material</label>
                    <input type="text" name="material" class="w-full border p-2 rounded">
                </div>

                {{-- Dimensi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Tinggi (cm)</label>
                    <input type="text" name="height" class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Lebar (cm)</label>
                    <input type="text" name="width" class="w-full border p-2 rounded">
                </div>

                {{-- Berat --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Berat (kg)</label>
                    <input type="text" name="weight" class="w-full border p-2 rounded">
                </div>

                {{-- Wilayah Asal --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Wilayah / Negara Asal</label>
                    <input type="text" name="region_of_origin" class="w-full border p-2 rounded">
                </div>

                {{-- Pembuat --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Pembuat / Pengrajin</label>
                    <input type="text" name="maker" class="w-full border p-2 rounded">
                </div>

                {{-- Kelangkaan --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Tingkat Kelangkaan</label>
                    <select name="rarity_level" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="Common">Common</option>
                        <option value="Rare">Rare</option>
                        <option value="Very Rare">Very Rare</option>
                    </select>
                </div>

                {{-- Sertifikat Keaslian --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Sertifikat Keaslian</label>
                    <select name="authenticity_certificate" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Status --</option>
                        <option value="Yes">Ada</option>
                        <option value="No">Tidak Ada</option>
                        <option value="Under verification">Sedang Proses Verifikasi</option>
                    </select>
                </div>

                {{-- Upload Sertifikat --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Upload Sertifikat</label>
                    <input type="file" name="authenticity_certificate_images" class="w-full border p-2 rounded">
                </div>

                {{-- Info Restorasi --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Informasi Restorasi</label>
                    <input type="text" name="restoration_info" class="w-full border p-2 rounded">
                </div>

                {{-- Provenance --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Riwayat Kepemilikan (Provenance)</label>
                    <textarea name="provenance" class="w-full p-2 border border-gray-300 rounded"></textarea>
                </div>

                {{-- Kategori --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Kategori</label>
                    <select name="category" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Collectibles">Collectibles</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Traditional Weapons">Traditional Weapons</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Furniture">Furniture</option>
                    </select>
                </div>

                {{-- Catatan Kerusakan --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Catatan Kerusakan</label>
                    <textarea name="damage_notes" class="w-full p-2 border border-gray-300 rounded"></textarea>
                </div>

                {{-- Lokasi Pengiriman --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Lokasi Pengiriman</label>
                    <input type="text" name="shipping_locations" class="w-full border p-2 rounded">
                </div>

                {{-- Biaya Pengiriman --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Opsi Pengiriman</label>
                    <select name="shipping_cost" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Opsi --</option>
                        <option value="Regular Shipping (0–1 kg) | from Rp6.500 | ETA: 2–3 days">Regular (0–1 kg)</option>
                        <option value="Medium Package (1–3 kg) | from Rp12.000 | ETA: 2–4 days">Medium (1–3 kg)</option>
                        <option value="Heavy Shipping (3–5 kg) | from Rp20.000 | ETA: 3–5 days">Heavy (3–5 kg)</option>
                    </select>
                </div>

                {{-- Stok --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Stok Barang</label>
                    <input type="number" name="stock" class="w-full border p-2 rounded" min="1">
                </div>

                {{-- Return Policy --}}
                <div class="mb-4">
                    <label class="block text-gray-700">Kebijakan Pengembalian</label>
                    <select name="returns_package" class="w-full border p-2 rounded">
                        <option value="">-- Pilih Kebijakan --</option>
                        <option value="30-Day Refund / Replacement">30-Day Refund / Replacement</option>
                        <option value="7-Day Refund Only">7-Day Refund Only</option>
                        <option value="No Return / Final Sale">No Return / Final Sale</option>
                    </select>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit" class="btn btn-primary">Jual Barang</button>
            </form>
        </div>
    </div>
</div>

@endsection
