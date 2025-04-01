@extends('customer.dashboard')

@section('content')
    <div class="container mx-auto mt-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Barang yang Pernah Anda Bid</h2>

            @if ($bids->isEmpty())
                <p class="text-gray-500 mt-4">Anda belum pernah melakukan bid.</p>
            @else
                <table class="w-full mt-4 border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama Barang</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Bid Anda</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bids as $bid)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('customer.bids.show', $bid->auction->id) }}"
                                        class="text-blue-500 hover:underline">
                                        {{ $bid->auction->name }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if ($bid->auction->status == 'ongoing')
                                        <span class="text-green-500 font-semibold">Sedang Berlangsung</span>
                                    @elseif ($bid->auction->status == 'ended' && $bid->is_highest)
                                        <span class="text-blue-500 font-semibold">Menang! Checkout dalam 24 jam</span>
                                    @elseif ($bid->auction->status == 'ended')
                                        <span class="text-red-500 font-semibold">Lelang Selesai</span>
                                    @elseif ($bid->auction->status == 'sold')
                                        <span class="text-gray-500 font-semibold">Sudah Terjual</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if ($bid->auction->status == 'ended' && $bid->is_highest && !$bid->auction->is_checkout_done)
                                        <a href="{{ route('customer.checkout', $bid->auction->id) }}"
                                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            Checkout
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('customer.bids.index') }}" class="block text-center mt-6 text-gray-500 hover:text-gray-700">
                🔙 Kembali ke Daftar Lelang
            </a>
        </div>
    </div>
@endsection
