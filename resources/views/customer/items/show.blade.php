@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="200"
                        class="mb-4">
                @endif
                <h3 class="text-xl font-semibold">{{ $item->name }}</h3>
                <p class="text-gray-600">{{ $item->description }}</p>
                <p style="font-style: italic" class="mt-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                <p class="mt-2">Status: <span class="font-semibold">{{ ucfirst($item->status) }}</span></p>

                <button><a href="{{ route('customer.items.index') }}" class="btn btn-primary mt-5">Kembali ke daftar
                        barang</a></button>
            </div>
        </div>
    </div>
@endsection
