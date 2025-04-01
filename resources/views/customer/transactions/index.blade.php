@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h2>

            @if (session('error'))
                <p class="text-red-500 mt-4">{{ session('error') }}</p>
            @endif

            @if ($transactions->isEmpty())
                <p class="text-gray-500 mt-4">Anda belum memiliki transaksi.</p>
            @else
                <table class="w-full mt-4 border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Barang</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Total Harga</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 flex items-center">
                                    @if ($transaction->auction)
                                        <img src="{{ asset('storage/' . $transaction->auction->image_path) }}"
                                            class="w-20 h-20 object-cover rounded mr-4">
                                        <div>
                                            <p class="text-lg font-bold">{{ $transaction->auction->name }}</p>
                                            <p class="text-gray-500">Dibeli dari Lelang</p>
                                        </div>
                                    @elseif ($transaction->item)
                                        <img src="{{ asset('storage/' . $transaction->item->image_path) }}"
                                            class="w-20 h-20 object-cover rounded mr-4">
                                        <div>
                                            <p class="text-lg font-bold">{{ $transaction->item->name }}</p>
                                            <p class="text-gray-500">Dibeli Langsung</p>
                                        </div>
                                    @else
                                        <p class="text-gray-500">Data barang tidak ditemukan</p>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if ($transaction->status == 'waiting_payment')
                                        <span class="text-yellow-500 font-semibold">Menunggu Pembayaran</span>
                                    @elseif ($transaction->status == 'processing')
                                        <span class="text-blue-500 font-semibold">Sedang Diproses</span>
                                    @elseif ($transaction->status == 'completed')
                                        <span class="text-green-500 font-semibold">Selesai</span>
                                    @elseif ($transaction->status == 'failed')
                                        <span class="text-red-500 font-semibold">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('customer.dashboard') }}" class="block text-center mt-6 text-gray-500 hover:text-gray-700">
                🔙 Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
