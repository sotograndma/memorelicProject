@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                <p style="font-weight: bold !important" class="font-bold">Lelang Saya</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

                <button class="btn btn_maroon"><a href="{{ route('customer.auctions.create') }}">Buat Lelang</a>
                </button>

                @if (session('success'))
                    <div class="bg-green-500 text-white p-2 mt-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="mt-4 w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-center">
                            <th class="border p-2">GAMBAR</th>
                            <th class="border p-2">NAMA BARANG</th>
                            <th class="border p-2">HARGA AWAL</th>
                            <th class="border p-2">HARGA AKHIR</th>
                            <th class="border p-2">BID TERTINGGI</th>
                            <th class="border p-2">STATUS</th>
                            <th class="border p-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($auctions as $auction)
                            <tr class="border">
                                <td class="border p-2">
                                    @if ($auction->image_path)
                                        <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}"
                                            width="100">
                                    @else
                                        <span class="text-gray-400">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="border p-2">{{ $auction->name }}</td>
                                <td class="border p-2">Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</td>
                                <td class="border p-2">
                                    @if ($auction->buy_now_price)
                                        Rp {{ number_format($auction->buy_now_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="border p-2">
                                    @if ($auction->highest_bid > 0)
                                        Rp {{ number_format($auction->highest_bid, 0, ',', '.') }}
                                    @else
                                        <span class="text-gray-400">Belum ada bid</span>
                                    @endif
                                </td>
                                <td class="border p-2">{{ ucfirst($auction->status) }}</td>
                                <td class="p-2 flex">
                                    <button class="btn btn-primary mr-2"><a
                                            href="{{ route('customer.auctions.show', $auction->id) }}">Lihat</a></button>
                                    <button class="btn btn-warning mr-2"><a
                                            href="{{ route('customer.auctions.edit', $auction->id) }}">Edit</a></button>
                                    <form action="{{ route('customer.auctions.destroy', $auction->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
