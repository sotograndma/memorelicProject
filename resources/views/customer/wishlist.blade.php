@extends('customer.dashboard')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="bg-white p-4 rounded-xl">
                <h3 class="fw-bold mb-4">Wishlist Saya</h3>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($wishlists->isEmpty())
                    <p class="text-muted">Wishlist Anda masih kosong.</p>
                @else
                    <div class="row">
                        @foreach ($wishlists as $wishlist)
                            @php
                                $product = $wishlist->item ?? $wishlist->auction;
                                $type = $wishlist->item ? 'item' : 'auction';
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text text-truncate">{{ $product->description }}</p>

                                        <div class="mt-auto d-flex justify-content-between">
                                            <a href="{{ $type === 'item' ? route('customer.orders.show', $product->id) : route('customer.bids.show', $product->id) }}" class="btn btn-sm btn-primary">
                                                Lihat Detail
                                            </a>

                                            <form method="POST" action="{{ route('customer.wishlist.destroy', $wishlist->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
