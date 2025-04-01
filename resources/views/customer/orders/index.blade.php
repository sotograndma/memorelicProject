@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Temukan Barang yang Anda Inginkan</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 mt-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($items as $item)
                @if ($item->status == 'available')
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <a href="{{ route('customer.orders.show', $item->id) }}">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                class="w-full h-48 object-cover rounded-lg">
                        </a>

                        <h3 class="text-lg font-bold mt-2 truncate">{{ $item->name }}</h3>

                        <p class="text-red-500 font-bold text-lg">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                        <p class="text-sm text-gray-500 flex items-center mt-1">
                            📍 Jakarta, Indonesia
                        </p>

                        <p class="text-sm text-gray-500 flex items-center mt-1">
                            ⭐ 4.9 | 500+ terjual
                        </p>

                        <div class="mt-3 flex space-x-2">
                            <a href="{{ route('customer.orders.show', $item->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Lihat</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
