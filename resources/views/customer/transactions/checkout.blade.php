@extends('customer.dashboard')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="bg_category p-4">

                <p class="fw-bold fs-5 mb-4">Checkout</p>

                <form action="{{ route('customer.checkout.process', ['item_id' => $auction ? $auction->id : $item->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="{{ $auction ? 'auction' : 'item' }}">
                    @if (!$auction)
                        <input type="hidden" name="quantity" value="{{ $quantity }}">
                    @endif

                    <div class="d-flex justify-content-between">
                        <div style="width: 100%" class="me-3">
                            @php
                                $defaultAddress = Auth::user()->userable->locations ?? '';
                            @endphp

                            <div class="bg-white p-3 rounded-xl mb-4">
                                <h3 class="font-semibold mb-3">Alamat Pengiriman</h3>

                                <!-- Default Alamat -->
                                <div id="defaultAddressBlock">
                                    <p><i class="bi bi-geo-alt-fill text-success"></i> <strong>Rumah • {{ Auth::user()->name }}</strong></p>
                                    <p>{{ $defaultAddress }}</p>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="toggleAddressEdit(true)">Ganti</button>
                                </div>

                                <!-- Alamat Custom -->
                                <div id="customAddressBlock" style="display: none;">
                                    <textarea name="shipping_address" class="form-control mb-2" rows="3"
                                        placeholder="Masukkan alamat lengkap pengiriman..."></textarea>

                                    <div class="d-flex justify-content-start gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="toggleAddressEdit(false)">Batal</button>
                                    </div>
                                </div>

                                <!-- Input tersembunyi jika pakai default -->
                                <input type="hidden" name="shipping_address" id="hiddenShippingAddress" value="{{ $defaultAddress }}">
                            </div>

                            <!-- Detail Produk -->
                            <div class="bg-white p-3 rounded-xl">
                                <h3 class="font-semibold mb-3">Produk yang Dibeli</h3>
                                <div class="flex items-end">
                                    <img src="{{ asset('storage/' . ($auction ? $auction->image_path : $item->image_path)) }}"
                                        class="w-20 h-20 object-cover rounded mr-4">
                                    <div>
                                        <p class="text-lg fw-bold">{{ $auction ? $auction->name : $item->name }}</p>
                                        @if (!$auction)
                                            <p class="mb-0">Jumlah: {{ $quantity }}</p>
                                            <p class="fs-6">Harga Satuan: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        @endif
                                        <p class="fs-6">Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="width: 100%">
                            <!-- Ringkasan Pembayaran -->
                            <div class="bg_main p-4 rounded-xl">
                                <p class="text-white fw-bold mb-3 fs-5">Ringkasan Pembayaran</p>
                                <p class="text-white">Total Harga: <strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></p>
                                <p class="text-white">Metode Pembayaran: <strong>Transfer Bank</strong></p>

                                <button style="width: 100%" type="submit" class="btn btn_maroon mt-3">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div style="height: 800px"></div>

<script>
    function toggleAddressEdit(showInput) {
        const defaultBlock = document.getElementById('defaultAddressBlock');
        const customBlock = document.getElementById('customAddressBlock');
        const hiddenInput = document.getElementById('hiddenShippingAddress');

        if (showInput) {
            defaultBlock.style.display = 'none';
            customBlock.style.display = 'block';
            hiddenInput.disabled = true;
        } else {
            defaultBlock.style.display = 'block';
            customBlock.style.display = 'none';
            hiddenInput.disabled = false;
        }
    }
</script>

@endsection
