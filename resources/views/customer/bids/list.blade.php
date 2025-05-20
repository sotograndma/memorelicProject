@extends('customer.dashboard')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">

            <div class="bg-white p-4 rounded-xl">
                <p class="fw-bold">Daftar Barang yang Pernah Anda Bid</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

                @if ($bids->isEmpty())
                    <p class="color_dark mt-4">Anda belum pernah melakukan bid.</p>
                @else
                    <table class="w-full mt-4 border-collapse border border-neutral-200">
                        <thead>
                            <tr style="font-size: 0.85em" class="bg-neutral-100">
                                <th class="border border-neutral-500 px-4 py-2 text-left">Nama Barang</th>
                                <th class="border border-neutral-500 px-4 py-2 text-center">Bid Anda</th>
                                <th class="border border-neutral-500 px-4 py-2 text-center">Status</th>
                                <th class="border border-neutral-500 px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bids as $bid)
                                <tr style="font-size: 0.85em">
                                    <td class="border border-neutral-300 px-4 py-2">
                                        <a href="{{ route('customer.bids.show', $bid->auction->id) }}"
                                            class="text-blue-500 hover:underline">
                                            {{ $bid->auction->name }}
                                        </a>
                                    </td>
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($bid->auction->status == 'ongoing')
                                            <span class="text-green-500 ">Sedang Berlangsung</span>
                                        @elseif ($bid->auction->status == 'ended' && $bid->is_highest)
                                            <span class="text-blue-500 ">Menang! Checkout dalam 24 jam</span>
                                        @elseif ($bid->auction->status == 'ended')
                                            <span class="text-red-500 ">Lelang Selesai</span>
                                        @elseif ($bid->auction->status == 'sold')
                                            <span class="text-neutral-500 ">Sudah Terjual</span>
                                        @endif
                                    </td>
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($bid->auction->status == 'ended' && $bid->is_highest && !$bid->auction->is_checkout_done)
                                            <a href="{{ route('customer.checkout', $bid->auction->id) }}"
                                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                                Checkout
                                            </a>
                                        @else
                                            <span class="text-neutral-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                {{-- <a style="font-size: 0.85em" href="{{ route('customer.bids.index') }}" class="block text-start mt-1 text-neutral-500 hover:text-neutral-700">
                    Kembali ke Daftar Lelang
                </a> --}}
            </div>

        </div>
    </div>

    <div style="height: 500px"></div>
@endsection
