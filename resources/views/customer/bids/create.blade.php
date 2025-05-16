@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="p-5 bg-white rounded-xl">
                <p class="fw-bold fs-5">Masukkan Penawaran</p>

                <p class="color_main mt-3">Barang: <strong>{{ $auction->name }}</strong></p>
                <p class="color_main">Harga Awal: <strong>Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</strong>
                </p>
                <p class="color_main">Bid Tertinggi Saat Ini: <strong>Rp
                        {{ number_format($auction->highest_bid, 0, ',', '.') }}</strong></p>
                <p class="color_main">Minimal Bid Baru:
                    <strong>Rp {{ number_format($auction->highest_bid + $auction->minimum_increment, 0, ',', '.') }}</strong>
                </p>

                <form action="{{ route('customer.bids.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="auction_id" value="{{ $auction->id }}">

                    <div class="mb-4">
                        <label style="font-size: 0.85em" for="bid_amount" class="block main_color fw-bold">Jumlah Penawaran</label>
                        <input type="number" id="bid_amount" name="bid_amount"
                            min="{{ $auction->highest_bid + $auction->minimum_increment }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-300"
                            required>
                    </div>

                    <button type="submit" class="w-full btn btn-main">
                        Bid Sekarang
                    </button>
                </form>

                <a style="font-size: 0.85em" href="{{ route('customer.bids.show', $auction->id) }}"
                    class="block text-start mt-1 underline color_main">
                    Back to Item Details
                </a>
            </div>
        </div>
    </div>
    
    <div style="height: 800px"></div>
@endsection
