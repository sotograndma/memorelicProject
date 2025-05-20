@extends('customer.sidebar')

@section('content')

<div class="d-flex flex-column">
    <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
        <div>
            <p class="fw-bold">Manajemen Pengiriman Barang</p>
            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

            @if (session('success'))
                <p class="text-green-600">{{ session('success') }}</p>
            @elseif (session('error'))
                <p class="text-red-600">{{ session('error') }}</p>
            @endif

            @if ($transactions->isEmpty())
                <p style="font-style: italic">Tidak ada transaksi dalam proses pengiriman.</p>
            @else
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-neutral-300 px-4 py-2 text-center">Barang</th>
                            <th class="border border-neutral-300 px-4 py-2 text-center">Pembeli</th>
                            <th class="border border-neutral-300 px-4 py-2 text-center">Status</th>
                            <th class="border border-neutral-300 px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $trx)
                            <tr>
                                <td class="border border-neutral-300 px-4 py-2 text-center">
                                    {{ $trx->item->name ?? $trx->auction->name }}
                                </td>
                                <td class="border border-neutral-300 px-4 py-2 text-center">{{ $trx->customer->name }}</td>
                                <td class="border border-neutral-300 px-4 py-2 text-center text-blue-500">{{ ucfirst(str_replace('_', ' ', $trx->status)) }}</td>
                                <td class="border border-neutral-300 px-4 py-2">
                                    @if ($trx->status == 'processing')
                                    
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="me-2">
                                            <form method="POST" action="{{ route('customer.transactions.update', $trx->id) }}">
                                                @csrf
                                                <input type="hidden" name="status" value="shipping_in_progress">
                                                <button type="submit" style="font-size: 0.85em;height: 100%" class="btn btn-primary"
                                                    onclick="return confirm('Konfirmasi bahwa barang sedang dikirim?')">Barang Sedang Dikirim</button>
                                            </form>
                                        </div>
    
                                        <div class="me-2">

                                        </div>
                                        <form method="POST" action="{{ route('customer.transactions.update', $trx->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="failed">
                                            <input type="text" name="failure_reason" placeholder="Alasan gagal..." required class="border p-2 rounded-2xl">
                                            <button style="font-size: 0.85em;" type="submit" class="btn btn_maroon w-full mt-2">Tandai Gagal</button>
                                        </form>
                                    </div>



                                    @elseif ($trx->status == 'shipping_in_progress')
                                        <!-- Tombol Barang Sudah Dikirim -->
                                        <form method="POST" action="{{ route('customer.transactions.update', $trx->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="shipped">
                                            <button type="submit" class="btn btn-success w-full" style="font-size: 0.85em;"
                                                onclick="return confirm('Konfirmasi bahwa barang sudah dikirim?')">Barang Sudah Dikirim</button>
                                        </form>
                                    @else
                                        <span class="text-neutral-500">Tidak ada aksi</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<div class="container py-4">
    
</div>
@endsection
