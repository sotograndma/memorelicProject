@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                @if ($auction->image_path)
                    <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}" width="200"
                        class="mb-4">
                @endif
                <h3 class="text-xl font-semibold">{{ $auction->name }}</h3>
                <p class="text-gray-600">{{ $auction->description }}</p>

                <p class="mt-4">Harga Awal: Rp
                    {{ number_format($auction->starting_bid, 0, ',', '.') }}</p>

                <p>
                <p>Harga Beli Sekarang: @if ($auction->buy_now_price)
                        Rp {{ number_format($auction->buy_now_price, 0, ',', '.') }}
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </p>

                <p>Bid Tertinggi: @if ($auction->highest_bid > 0)
                        Rp {{ number_format($auction->highest_bid, 0, ',', '.') }}
                    @else
                        <span class="text-gray-400">Belum ada bid</span>
                    @endif
                </p>

                <p>Minimum Incremental Bid: Rp {{ number_format($auction->minimum_increment, 0, ',', '.') }}</p>
                <p>Waktu Mulai: {{ date('d M Y H:i', strtotime($auction->start_time)) }}</p>
                <p>Waktu Berakhir: {{ date('d M Y H:i', strtotime($auction->end_time)) }}</p>
                <p>Status: {{ ucfirst($auction->status) }}</p>

                <button class="btn btn-primary mt-4"><a href="{{ route('customer.auctions.index') }}">Kembali ke daftar
                        lelang</a></button>
            </div>
        </div>
    </div>
@endsection
