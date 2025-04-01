@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Kode Pembayaran</h2>

        <div class="bg-white p-6 rounded shadow-md">
            <p class="text-lg">Gunakan kode ini untuk melakukan transfer:</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $transaction->payment_code }}</p>

            <div class="mt-4">
                <p class="text-gray-600">Pastikan Anda mentransfer sesuai dengan jumlah total:</p>
                <p class="text-2xl font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('customer.payment.process', ['transaction_id' => $transaction->id]) }}"
                    class="bg-yellow-500 text-white px-6 py-2 rounded shadow hover:bg-yellow-600">
                    Saya Sudah Membayar
                </a>
            </div>
        </div>
    </div>
@endsection
