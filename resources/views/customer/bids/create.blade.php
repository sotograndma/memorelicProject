@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800">Masukkan Penawaran</h2>
            <p class="text-gray-500 mt-1">Barang: <strong>{{ $auction->name }}</strong></p>
            <p class="text-gray-500">Harga Awal: <strong>Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</strong>
            </p>
            <p class="text-gray-500">Bid Tertinggi Saat Ini: <strong>Rp
                    {{ number_format($auction->highest_bid, 0, ',', '.') }}</strong></p>
            <p class="text-gray-500">Minimal Bid Baru:
                <strong>Rp {{ number_format($auction->highest_bid + $auction->minimum_increment, 0, ',', '.') }}</strong>
            </p>

            <form action="{{ route('customer.bids.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="auction_id" value="{{ $auction->id }}">

                <div class="mb-4">
                    <label for="bid_amount" class="block text-gray-700 font-semibold">Jumlah Penawaran</label>
                    <input type="number" id="bid_amount" name="bid_amount"
                        min="{{ $auction->highest_bid + $auction->minimum_increment }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                    Bid Sekarang
                </button>
            </form>

            <a href="{{ route('customer.bids.show', $auction->id) }}"
                class="block text-center mt-4 text-gray-500 hover:text-gray-700">
                🔙 Kembali ke Detail Barang
            </a>
        </div>
    </div>
@endsection
