@extends('customer.sidebar')

@section('content')
<div class="d-flex flex-column">
    <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
        <div>
            {{-- Gambar Utama --}}
            @if ($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="300" class="mb-4">
            @endif

            {{-- Nama & Harga --}}
            <h3 class="text-xl font-semibold">{{ $item->name }}</h3>
            <p class="text-gray-600">{{ $item->description }}</p>
            <p class="mt-2 italic">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
            <p>Status: <span class="font-semibold">{{ ucfirst($item->status) }}</span></p>

            {{-- Informasi Barang --}}
            <hr class="my-4">
            <h4 class="font-bold text-lg mb-2">Informasi Barang</h4>
            <ul class="space-y-1">
                <li><strong>Kondisi:</strong> {{ $item->condition ?? '-' }}</li>
                <li><strong>Minimal Order:</strong> {{ $item->min_order ?? '-' }}</li>
                <li><strong>Tahun Pembuatan:</strong> {{ $item->year_of_origin ? \Carbon\Carbon::parse($item->year_of_origin)->translatedFormat('d F Y') : '-' }}</li>
                <li><strong>Material:</strong> {{ $item->material ?? '-' }}</li>
                <li><strong>Dimensi (T x L):</strong> {{ $item->height ?? '-' }} cm x {{ $item->width ?? '-' }} cm</li>
                <li><strong>Berat:</strong> {{ $item->weight ?? '-' }} kg</li>
                <li><strong>Wilayah / Negara Asal:</strong> {{ $item->region_of_origin ?? '-' }}</li>
                <li><strong>Pembuat / Pengrajin:</strong> {{ $item->maker ?? '-' }}</li>
                <li><strong>Tingkat Kelangkaan:</strong> {{ $item->rarity_level ?? '-' }}</li>
                <li><strong>Restorasi:</strong> {{ $item->restoration_info ?? '-' }}</li>
                <li><strong>Provenance:</strong> {{ $item->provenance ?? '-' }}</li>
                <li><strong>Kategori:</strong> {{ $item->category ?? '-' }}</li>
                <li><strong>Catatan Kerusakan:</strong> {{ $item->damage_notes ?? '-' }}</li>
            </ul>

            {{-- Sertifikat --}}
            <div class="mt-4">
                <p><strong>Sertifikat Keaslian:</strong> {{ $item->authenticity_certificate ?? '-' }}</p>
                @if ($item->authenticity_certificate_images)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $item->authenticity_certificate_images) }}" alt="Sertifikat" width="200">
                    </div>
                @endif
            </div>

            {{-- Pengiriman & Retur --}}
            <hr class="my-4">
            <h4 class="font-bold text-lg mb-2">Pengiriman & Retur</h4>
            <ul class="space-y-1">
                <li><strong>Lokasi Pengiriman:</strong> {{ $item->shipping_locations ?? '-' }}</li>
                <li><strong>Opsi Pengiriman:</strong> {{ $item->shipping_cost ?? '-' }}</li>
                <li><strong>Stok Tersedia:</strong> {{ $item->stock ?? '-' }} item</li>
                <li><strong>Kebijakan Retur:</strong> {{ $item->returns_package ?? '-' }}</li>
            </ul>

            {{-- Tombol --}}
            <button>
                <a href="{{ route('customer.items.index') }}" class="btn btn-primary mt-5">Kembali ke Daftar Barang</a>
            </button>
        </div>
    </div>
</div>
@endsection
