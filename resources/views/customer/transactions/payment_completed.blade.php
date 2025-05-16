@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            
            <div class="bg_jual-beli p-4">

                <div class="bg-white rounded-xl p-4 mb-4">
                    <p class="fw-bold mb-2 fs-5">Pembayaran Berhasil!</p>
                    <p class="">Terima kasih telah berbelanja di <strong>Memorelic</strong>.</p>
                    <p class="">Pembayaran Anda telah berhasil diproses.</p>
                </div>

                <div class="bg-white p-4 rounded-xl d-flex justify-content-around">
                    <div class="">
                        <p class="">Total Pembayaran:</p>
                        <p style="font-style: italic" class="fw-bold fs-5">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>

                    <div class="">
                        <p class="">Kode Pembayaran:</p>
                        <p class="fs-5 fw-bold color_maroonMain">{{ $transaction->payment_code }}</p>
                    </div>
                </div>

                <div class="mt-5">
                    
                    <p class="color_main">Anda dapat melihat status pesanan di halaman <span class="fw-bold">Riwayat Transaksi</span>.</p>
                    
                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('customer.transactions.history') }}"
                            class="btn btn-primary me-3" style="width: 100%">
                            Lihat Riwayat Transaksi
                        </a>
                        <a href="{{ route('customer.dashboard') }}"
                            class="btn btn-main" style="width: 100%">
                            Kembali ke Beranda
                        </a>
                    </div>
                

                </div>

            </div>

        </div>
    </div>

    <div style="height: 800px"></div>
@endsection
