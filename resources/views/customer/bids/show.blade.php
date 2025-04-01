@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <div class="flex flex-col md:flex-row gap-6">

            <!-- Gambar Produk -->
            <div class="w-full md:w-1/2">
                <div class="border rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}"
                        class="w-full h-96 object-cover">
                </div>
            </div>

            <!-- Informasi Produk -->
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl font-bold">{{ $auction->name }}</h2>

                <p class="text-red-500 font-bold text-3xl mt-2">Harga Awal: Rp
                    {{ number_format($auction->starting_bid, 0, ',', '.') }}
                </p>

                <p class="text-green-500 font-bold text-xl mt-1">
                    Bid Tertinggi Saat Ini: Rp {{ number_format($auction->highest_bid, 0, ',', '.') }}
                </p>

                <p class="text-gray-600 mt-1">
                    Bidder Tertinggi:
                    <strong class="text-blue-500">
                        {{ optional($auction->highestBidder)->name ?? 'Belum ada bid' }}
                    </strong>
                </p>

                <!-- Status Lelang -->
                <p class="mt-2 text-gray-700">
                    <strong>Status Lelang:</strong>
                    @if ($auction->status == 'ongoing')
                        <span class="text-green-500">Sedang Berlangsung</span>
                    @elseif ($auction->status == 'ended')
                        <span class="text-red-500">Lelang Selesai</span>
                    @elseif ($auction->status == 'sold')
                        <span class="text-gray-500">Barang Terjual</span>
                    @endif
                </p>

                <!-- Info Bid User Sendiri -->
                @php
                    $userBid = $auction->bids
                        ->where('customer_id', auth()->user()->userable_id)
                        ->sortByDesc('bid_amount')
                        ->first();
                @endphp
                @if ($userBid)
                    <p class="text-blue-500 mt-2">
                        💰 <strong>Bid Anda:</strong> Rp {{ number_format($userBid->bid_amount, 0, ',', '.') }}
                    </p>
                @else
                    <p class="text-gray-500 mt-2">Anda belum pernah melakukan bid pada lelang ini.</p>
                @endif

                <!-- Tombol Bid -->
                @if ($auction->status == 'ongoing')
                    <div class="mt-6">
                        <a href="{{ route('customer.bids.create', $auction->id) }}"
                            class="bg-yellow-500 text-white px-6 py-2 rounded shadow hover:bg-yellow-600">
                            Bid Barang
                        </a>
                    </div>
                @endif

                <!-- Navigasi ke Daftar Bid User -->
                <div class="mt-4">
                    <a href="{{ route('customer.bids.list') }}" class="text-blue-500 hover:underline">
                        🔍 Lihat Barang yang Pernah Anda Bid
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
