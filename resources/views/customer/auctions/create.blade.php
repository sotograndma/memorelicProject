@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                <p style="font-weight: bold !important" class="font-bold">Lelang Barang Baru</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-2 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customer.auctions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Barang</label>
                        <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga Awal (Rp)</label>
                        <input type="number" name="starting_bid" class="w-full p-2 border border-gray-300 rounded"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga Beli Sekarang (Rp) <span
                                class="text-gray-500">(Opsional)</span></label>
                        <input type="number" name="buy_now_price" class="w-full p-2 border border-gray-300 rounded"
                            placeholder="Masukkan harga Buy Now">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Minimum Incremental Bid (Rp)</label>
                        <input type="number" name="minimum_increment" class="w-full p-2 border border-gray-300 rounded"
                            value="5000" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" class="w-full p-2 border border-gray-300 rounded"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Waktu Berakhir</label>
                        <input type="datetime-local" name="end_time" class="w-full p-2 border border-gray-300 rounded"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Upload Gambar</label>
                        <input type="file" name="image" class="w-full border p-2 rounded">
                    </div>

                    <button type="submit" class="btn btn-primary">Jual Barang</button>
                </form>
            </div>
        </div>
    </div>

@endsection
