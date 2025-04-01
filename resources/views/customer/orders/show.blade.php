@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <div class="flex flex-col md:flex-row gap-6">

            <!-- Gambar Produk -->
            <div class="w-full md:w-1/2">
                <div class="border rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                        class="w-full h-96 object-cover">
                </div>
                <div class="flex gap-2 mt-2">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                        class="w-20 h-20 border rounded-lg object-cover">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                        class="w-20 h-20 border rounded-lg object-cover">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                        class="w-20 h-20 border rounded-lg object-cover">
                </div>
            </div>

            <!-- Informasi Produk -->
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl font-bold">{{ $item->name }}</h2>
                <p class="text-gray-500">Terjual 250+ | ⭐ 5 (166 rating)</p>

                <p class="text-red-500 font-bold text-3xl mt-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                <div class="mt-4 border-t pt-4">
                    <h3 class="font-semibold">Detail</h3>
                    <p class="text-gray-600"><strong>Kondisi:</strong> Baru</p>
                    <p class="text-gray-600"><strong>Min. Pemesanan:</strong> 1 Buah</p>
                    <p class="text-gray-600"><strong>Deskripsi:</strong> {{ $item->description }}</p>
                </div>

                <!-- Tombol Interaksi -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">🔔 Aktifkan
                        Notifikasi</button>
                    <button class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600">💬 Chat
                        Penjual</button>
                    <button class="bg-pink-500 text-white px-4 py-2 rounded shadow hover:bg-pink-600">❤️ Wishlist</button>
                </div>

                <!-- Form Order -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="font-semibold mb-2">Atur Jumlah dan Catatan</h3>
                    <div class="flex items-center">
                        <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded-l">-</button>
                        <input type="number" value="1" min="1"
                            class="w-16 text-center border-t border-b border-gray-300">
                        <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded-r">+</button>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Stok: <strong>151</strong> | Max. pembelian: 76 pcs</p>
                    <p class="text-lg font-bold mt-2">Subtotal: Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                    <div class="mt-4 flex gap-3">
                        <button class="bg-yellow-500 text-white px-6 py-2 rounded shadow hover:bg-yellow-600">+
                            Keranjang</button>
                        <!-- Tombol Beli Langsung -->
                        <a href="{{ route('customer.checkout', ['item_id' => $item->id]) }}"
                            class="bg-green-500 text-white px-6 py-2 rounded shadow hover:bg-green-600">
                            Beli Langsung
                        </a>
                    </div>
                </div>

                <!-- Info Pengiriman -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="font-semibold mb-2">Pengiriman</h3>
                    <p class="text-gray-600">📍 Dikirim dari <strong>Jakarta Utara</strong></p>
                    <p class="text-gray-600">🚚 Ongkir mulai Rp6.500</p>
                    <p class="text-gray-600">📅 Estimasi tiba: 1 - 3 Mar</p>
                </div>

            </div>
        </div>
    </div>
@endsection
