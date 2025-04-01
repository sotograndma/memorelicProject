@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Checkout</h2>

        <form action="{{ route('customer.checkout.process', ['item_id' => $auction ? $auction->id : $item->id]) }}"
            method="POST">
            @csrf
            <!-- Alamat Pengiriman -->
            <div class="bg-white p-4 rounded shadow-md mb-4">
                <h3 class="font-semibold mb-2">Alamat Pengiriman</h3>
                <textarea name="shipping_address" required class="w-full border p-2 rounded"
                    placeholder="Masukkan alamat lengkap pengiriman..."></textarea>
            </div>

            <!-- Detail Produk -->
            <div class="bg-white p-4 rounded shadow-md mb-4">
                <h3 class="font-semibold mb-2">Produk yang Dibeli</h3>
                <div class="flex items-center">
                    <img src="{{ asset('storage/' . ($auction ? $auction->image_path : $item->image_path)) }}"
                        class="w-20 h-20 object-cover rounded mr-4">
                    <div>
                        <p class="text-lg font-bold">{{ $auction ? $auction->name : $item->name }}</p>
                        <p class="text-gray-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="bg-white p-4 rounded shadow-md mb-4">
                <h3 class="font-semibold mb-2">Ringkasan Pembayaran</h3>
                <p class="text-gray-700">Total Harga: <strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></p>
                <p class="text-gray-700">Metode Pembayaran: <strong>Transfer Bank</strong></p>
            </div>

            <!-- Tombol Checkout -->
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded shadow w-full">Bayar Sekarang</button>
        </form>
    </div>
@endsection
