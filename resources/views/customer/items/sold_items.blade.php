@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                <p style="font-weight: bold !important" class="font-bold">Daftar Barang Terjual</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

                @if ($soldItems->isEmpty())
                    <p class="text-gray-500 text-center">Belum ada barang yang terjual.</p>
                @else
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2 text-center">NO</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">NAMA BARANG</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">HARGA</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">PEMBELI</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($soldItems as $index => $item)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $item->name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">Rp
                                        {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($item->transactions->isNotEmpty())
                                            {{ $item->transactions->first()->customer->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($item->transactions->isNotEmpty() && $item->transactions->first()->customer)
                                            {{ $item->transactions->first()->customer->name }}
                                        @else
                                            -
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

@endsection
