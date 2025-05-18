@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            
            <div class="bg-white p-4 rounded-xl">
                <p class="fw-bold">Riwayat Transaksi</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

                @if (session('error'))
                    <p class="text-red-500 mt-4">{{ session('error') }}</p>
                @endif

                @if ($transactions->isEmpty())
                    <p class="text-neutral-500 mt-4">Anda belum memiliki transaksi.</p>
                @else
                    <table class="w-full mt-4 border-collapse border border-neutral-200">
                        <thead>
                            <tr class="bg-neutral-100">
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Gambar</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Nama Barang</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Jenis Transaksi</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Total Harga</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <!-- Kolom Gambar -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($transaction->auction)
                                            <img src="{{ asset('storage/' . $transaction->auction->image_path) }}" class="w-20 h-20 object-cover rounded mx-auto">
                                        @elseif ($transaction->item)
                                            <img src="{{ asset('storage/' . $transaction->item->image_path) }}" class="w-20 h-20 object-cover rounded mx-auto">
                                        @else
                                            <span class="text-neutral-500">Tidak tersedia</span>
                                        @endif
                                    </td>

                                    <!-- Kolom Nama Barang -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($transaction->auction)
                                            {{ $transaction->auction->name }}
                                        @elseif ($transaction->item)
                                            {{ $transaction->item->name }}
                                        @else
                                            <span class="text-neutral-500">Tidak diketahui</span>
                                        @endif
                                    </td>

                                    <!-- Kolom Jenis Transaksi -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($transaction->auction)
                                            Dibeli dari Lelang
                                        @elseif ($transaction->item)
                                            Dibeli Langsung
                                        @else
                                            Tidak diketahui
                                        @endif
                                    </td>

                                    <!-- Kolom Total Harga -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>

                                    <!-- Kolom Status -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($transaction->status == 'waiting_payment')
                                            <span class="text-yellow-500">Menunggu Pembayaran</span>
                                        @elseif ($transaction->status == 'processing')
                                            <span class="text-blue-500">Sedang Diproses</span>
                                        @elseif ($transaction->status == 'completed')
                                            <span class="text-green-500">Selesai</span>
                                        @elseif ($transaction->status == 'failed')
                                            <span class="text-red-500">Gagal</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @endif

                {{-- <a href="{{ route('customer.dashboard') }}" class="block text-start mt-2 text-neutral-500 hover:text-neutral-700">
                    Kembali ke Beranda
                </a> --}}
            </div>

        </div>
    </div>

    <div style="height: 300px"></div>
@endsection
