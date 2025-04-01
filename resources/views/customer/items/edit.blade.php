@extends('customer.sidebar')

@section('content')

    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                <p style="font-weight: bold !important" class="font-bold">Edit Barang</p>
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

                <form action="{{ route('customer.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nama Barang</label>
                        <input type="text" name="name" value="{{ old('name', $item->name) }}"
                            class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Deskripsi</label>
                        <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required>{{ old('description', $item->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $item->price) }}"
                            class="w-full p-2 border border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Gambar Saat Ini</label>
                        @if ($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="Gambar {{ $item->name }}"
                                width="150" class="mb-2">
                        @endif
                        <input type="file" name="image" class="w-full border p-2 rounded">
                    </div>

                    <button type="submit" class="btn btn-warning">Update Barang<a href=""></a></button>
                </form>
            </div>
        </div>
    </div>

@endsection
