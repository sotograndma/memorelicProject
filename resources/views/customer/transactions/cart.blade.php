@extends('customer.dashboard')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div style="width: 1200px">
        <div class="bg-white p-4 rounded-xl">

            <p class="fw-bold fs-6">Keranjang</p>
            <p class="mb-4 ">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse minus doloribus libero dolorum ipsa quam nisi, obcaecati eos dolorem neque?</p>
    
            @if(session('cart'))
                <div class="d-flex justify-content-between align-items-start">

                    <div class="col-md-8">
                        @foreach($cart as $id => $item)
                            <div class="d-flex justify-content-between align-items-end me-3 mb-3 bg_category">
                                <div class="d-flex gap-2 align-items-end">
                                    <img class="rounded-lg" src="{{ asset('storage/' . $item['image']) }}" alt="" width="70">
                                    <div>
                                        <p class="">{{ $item['name'] }}</p>
                                        <small class="fw-bold">Rp{{ number_format($item['price'], 0, ',', '.') }}</small>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('customer.cart.remove', $id) }}">
                                    @csrf
                                    <button class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-4">
                        <div class="bg_category">
                            <h5>Ringkasan Belanja</h5>
                            <p class="mb-4">Total: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></p>
                            <form action="{{ route('customer.cart.checkout') }}" method="POST">
                                @csrf
                                <button class="btn btn_maroon w-100">Beli ({{ count($cart) }})</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-muted">Keranjang Anda kosong.</p>
            @endif

        </div>
    </div>
</div>
@endsection
