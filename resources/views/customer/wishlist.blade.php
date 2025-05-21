@extends('customer.dashboard')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="bg-white p-4 rounded-xl">
                <p class="fw-bold fs-6">Wishlist Saya</p>
                <p class="mb-4 ">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse minus doloribus libero dolorum ipsa quam nisi, obcaecati eos dolorem neque?</p>

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
                            <div class="col-md-3 mb-4">

                                <div class="bg_category">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top rounded-xl mb-2" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <p class="fw-bold mt-2">{{ $product->name }}</p>
                                        <p class="italic">{{ $product->description }}</p>

                                        <div class="mt-5 d-flex">
                                            <a href="{{ $type === 'item' ? route('customer.orders.show', $product->id) : route('customer.bids.show', $product->id) }}" class="btn btn_maroon me-2">
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
