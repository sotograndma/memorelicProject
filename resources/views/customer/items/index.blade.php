@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div class="">
                <p style="font-weight: bold !important" class="font-bold">Barang yang Anda Jual</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>
                <button class="btn btn-primary"><a href="{{ route('customer.items.create') }}">Jual
                        Barang</a></button>

                @if (session('success'))
                    <div class="bg-green-300 text-white p-2 mt-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="mt-4 w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100 text-center">
                            <th class="border p-2">GAMBAR</th>
                            <th class="border p-2">NAMA</th>
                            <th class="border p-2">HARGA</th>
                            <th class="border p-2">STATUS</th>
                            <th class="border p-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="border">
                                <td class="border p-2">
                                    @if ($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                            width="100">
                                    @else
                                        <span class="text-gray-400">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="border p-2">{{ $item->name }}</td>
                                <td class="border p-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="border p-2">{{ ucfirst($item->status) }}</td>
                                <td class="flex p-2">
                                    <button class="btn btn-primary mr-2"><a
                                            href="{{ route('customer.items.show', $item->id) }}">Lihat</a></button>
                                    <button class="btn btn-warning mr-2"><a
                                            href="{{ route('customer.items.edit', $item->id) }}">Edit</a></button>
                                    <form action="{{ route('customer.items.destroy', $item->id) }}" method="POST">
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
