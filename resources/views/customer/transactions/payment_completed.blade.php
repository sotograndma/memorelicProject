@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6 text-center">
        <h2 class="text-2xl font-bold mb-4 text-green-600">Pembayaran Berhasil!</h2>

        <div class="bg-white p-6 rounded shadow-md">
            <p class="text-lg text-gray-700">Terima kasih telah berbelanja di <strong>Memorelic</strong>.</p>
            <p class="text-sm text-gray-500 mt-2">Pembayaran Anda telah berhasil diproses.</p>

            <div class="mt-6">
                <p class="text-gray-600">Total Pembayaran:</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                </p>
            </div>

            <div class="mt-6">
                <p class="text-gray-600">Kode Pembayaran:</p>
                <p class="text-3xl font-bold text-blue-600">{{ $transaction->payment_code }}</p>
            </div>

            <div class="mt-6">
                <p class="text-gray-500">Anda dapat melihat status pesanan di halaman <strong>Riwayat Transaksi</strong>.
                </p>
            </div>

            <div class="mt-8">
                <a href="{{ route('customer.transactions.history') }}"
                    class="bg-blue-500 text-white px-6 py-2 rounded shadow hover:bg-blue-600">
                    Lihat Riwayat Transaksi
                </a>
                <a href="{{ route('customer.dashboard') }}"
                    class="bg-green-500 text-white px-6 py-2 rounded shadow hover:bg-green-600 ml-4">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
