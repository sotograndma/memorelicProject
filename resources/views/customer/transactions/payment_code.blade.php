@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="d-flex justify-content-between">

                <div style="width: 100%" class="bg_category p-4 me-4">

                    <div class="bg-white rounded-xl p-4 mb-4">
                        <p class="fw-bold fs-5 mb-2">Terima kasih telah melakukan pembelian di Memorelic.</p>
                        <p>Silakan lakukan pembayaran dengan mentransfer ke nomor virtual account berikut menggunakan aplikasi mobile banking, ATM, atau layanan lainnya.</p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-xl">
                        <p class="fw-bold fs-5 mb-4">Kode Pembayaran</p>
                        <p class="mt-2">Gunakan kode ini untuk melakukan transfer:</p>
                        <p class="fs-5 fw-bold color_maroon">{{ $transaction->payment_code }}</p>
    
                        <div class="mt-4 main_color">
                            <p class="">Pastikan Anda mentransfer sesuai dengan jumlah total:</p>
                            <p style="font-style: italic" class="fw-bold fs-5">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        </div>

                    </div>
                    
                    <div class="mt-4 text-center">
                            <a href="{{ route('customer.payment.process', ['transaction_id' => $transaction->id]) }}"
                                class="btn btn_maroon" style="width: 100%">
                                Saya Sudah Membayar
                            </a>
                    </div>

                </div>

                <div class="bg_dark d-flex align-items-center justify-content-center p-4" style="width: 30%">
                    <div class="color_cream">
                        <p class="fw-bold fs-5 color_cream">Mohon perhatikan:</p>
                        <p>Transfer hanya dapat dilakukan satu kali sesuai jumlah yang tertera.</p>
                        <p>Jangan lupa untuk klik tombol "Saya Sudah Membayar" setelah menyelesaikan transfer.</p>
                        <p>Pembayaran akan diverifikasi secara otomatis dalam waktu maksimal 10 menit setelah transfer.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div style="height: 800px"></div>
@endsection
