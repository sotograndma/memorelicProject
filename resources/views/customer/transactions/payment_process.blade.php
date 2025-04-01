@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6 text-center">
        <h2 class="text-2xl font-bold mb-4">Menunggu Verifikasi Pembayaran</h2>

        <div class="bg-white p-6 rounded shadow-md">
            <p class="text-lg text-gray-700">Kami sedang memproses pembayaran Anda...</p>
            <p class="text-sm text-gray-500 mt-2">Jika pembayaran telah berhasil, status transaksi akan diperbarui secara
                otomatis.</p>

            <div class="mt-6">
                <p class="text-gray-600">Total yang harus dibayar:</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                </p>
            </div>

            <div class="mt-6">
                <p class="text-gray-600">Kode Pembayaran:</p>
                <p class="text-3xl font-bold text-blue-600">{{ $transaction->payment_code }}</p>
            </div>

            <div class="mt-6">
                <p class="text-gray-500">Jika sudah melakukan pembayaran, silakan tunggu beberapa saat.</p>
                <p class="text-gray-500">Atau hubungi admin jika ada kendala.</p>
            </div>

            <div class="mt-8">
                <a href="{{ route('customer.payment.completed', ['transaction_id' => $transaction->id]) }}"
                    class="bg-green-500 text-white px-6 py-2 rounded shadow hover:bg-green-600">
                    Selesai & Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
