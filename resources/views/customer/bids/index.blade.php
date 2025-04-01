@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Lelang yang Sedang Berlangsung</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 mt-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($auctions as $auction)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <a href="{{ route('customer.bids.show', $auction->id) }}">
                        <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}"
                            class="w-full h-48 object-cover rounded-lg">
                    </a>

                    <h3 class="text-lg font-bold mt-2 truncate">{{ $auction->name }}</h3>

                    <p class="text-red-500 font-bold text-lg">Harga Awal: Rp
                        {{ number_format($auction->starting_bid, 0, ',', '.') }}</p>

                    <p class="text-sm text-gray-500 flex items-center mt-1">
                        ⏳ Mulai: {{ date('d M Y H:i', strtotime($auction->start_time)) }}
                    </p>
                    <p class="text-sm text-gray-500 flex items-center">
                        ⏳ Berakhir: {{ date('d M Y H:i', strtotime($auction->end_time)) }}
                    </p>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('customer.bids.show', $auction->id) }}"
                            class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Lihat Lelang</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
