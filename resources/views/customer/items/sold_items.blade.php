@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                <p class="fw-bold">Daftar Barang Terjual</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

                @if ($soldItems->isEmpty())
                    <p class="italic">Belum ada barang yang terjual.</p>
                @else
                    <table class="w-full border-collapse border border-neutral-300">
                        <thead>
                            <tr class="bg-neutral-100">
                                <th class="border border-neutral-300 px-4 py-2 text-center">No</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Nama Barang</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Tipe Barang</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Harga</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Pembeli</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Kuantitas</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Total</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Tanggal</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center">Alamat Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($soldItems as $index => $item)
                                @foreach ($item->transactions as $transaction)
                                    <tr>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                        <td class="border border-neutral-300 px-4 py-2">{{ $item->name }}</td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">Barang Biasa (Bukan Lelang)</td>
                                        <td class="border border-neutral-300 px-4 py-2">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2">
                                            {{ $transaction->customer->name ?? '-' }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">
                                            {{ $transaction->quantity }}x
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">
                                            Rp {{ number_format($item->price * $transaction->quantity, 0, ',', '.') }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">
                                            {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2">
                                            {{ $transaction->shipping_address }}
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            @endforeach
                            @foreach ($soldAuctions as $index => $auction)
                                @if ($auction->transaction)
                                    <tr>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">L{{ $index + 1 }}</td>
                                        <td class="border border-neutral-300 px-4 py-2">{{ $auction->name }}</td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">Barang Lelang</td>

                                        <td class="border border-neutral-300 px-4 py-2">
                                            Rp {{ number_format($auction->transaction->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2">
                                            {{ $auction->transaction->customer->name ?? '-' }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">
                                            1x
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">
                                            Rp {{ number_format($auction->transaction->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2 text-center">
                                            {{ \Carbon\Carbon::parse($auction->transaction->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="border border-neutral-300 px-4 py-2">
                                            {{ $auction->transaction->shipping_address }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>

@endsection
