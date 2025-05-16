@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">

            <div class="d-flex justify-content-between">
                
                <div style="width: 100%" class="bg_jual-beli p-4 me-4">
                    <div class="bg-white p-4 rounded-xl mb-4">
                        <p class="fs-5 fw-bold mb-2">Menunggu Verifikasi Pembayaran</p>
                        <p class="">Kami sedang memproses pembayaran Anda...</p>
                        <p class="">Jika pembayaran telah berhasil, status transaksi akan diperbarui secara
                            otomatis.</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl mb-4">
                        <div class="">
                            <p class="">Total yang harus dibayar:</p>
                            <p style="font-style: italic" class="fw-bold fs-5">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="mt-4">
                            <p class="">Kode Pembayaran:</p>
                            <p class="fs-5 fw-bold color_maroonMain">{{ $transaction->payment_code }}</p>
                        </div>

                        <div class="mt-4">
                            <p class="">Jika sudah melakukan pembayaran, silakan tunggu beberapa saat Atau hubungi admin jika ada kendala.</p>
                        </div>
                    </div>

                    <a href="{{ route('customer.payment.completed', ['transaction_id' => $transaction->id]) }}"
                            class="btn btn-main" style="width: 100%">
                            Selesai & Kembali ke Beranda
                    </a>
                    
                    <div class="text-sm mt-3">
                        <p class="fw-bold">Masih ada kendala?</p>
                        <p>Hubungi tim bantuan kami melalui WhatsApp di <span class="fw-bold">0812-3456-7890</span> <br>atau kirim email ke <span style="text-decoration: underline; font-style: italic">support@memorelic.com</span>.</p>
                    </div>

                </div>

                <div class="bg_jualLelang d-flex align-items-center justify-content-center p-4" style="width: 30%">
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
