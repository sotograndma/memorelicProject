@extends('customer.sidebar')

@section('content')
    <div class="d-flex flex-column">
        <div style="width: 100%; height: fit-content; background-color:white;border-radius:10px" class="p-4 flex-grow-1">
            <div>
                @if ($auction->image_path)
                    <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}" width="200" class="mb-4">
                @endif

                <h3 class="text-xl font-semibold">{{ $auction->name }}</h3>
                <p class="text-gray-600">{{ $auction->description }}</p>

                <div class="mt-4">
                    <p><strong>Harga Awal:</strong> Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</p>
                    <p><strong>Harga Beli Sekarang:</strong>
                        @if ($auction->buy_now_price)
                            Rp {{ number_format($auction->buy_now_price, 0, ',', '.') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </p>
                    <p><strong>Bid Tertinggi:</strong>
                        @if ($auction->highest_bid > 0)
                            Rp {{ number_format($auction->highest_bid, 0, ',', '.') }}
                        @else
                            <span class="text-gray-400">Belum ada bid</span>
                        @endif
                    </p>
                    <p><strong>Minimum Incremental Bid:</strong> Rp {{ number_format($auction->minimum_increment, 0, ',', '.') }}</p>
                    <p><strong>Waktu Mulai:</strong> {{ date('d M Y H:i', strtotime($auction->start_time)) }}</p>
                    <p><strong>Waktu Berakhir:</strong> {{ date('d M Y H:i', strtotime($auction->end_time)) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($auction->status) }}</p>
                </div>

                <hr class="my-4">

                <div>
                    <p><strong>Kondisi:</strong> {{ $auction->condition ?? '-' }}</p>
                    <p><strong>Tahun Pembuatan:</strong> {{ $auction->year_of_origin ? date('Y', strtotime($auction->year_of_origin)) : '-' }}</p>
                    <p><strong>Material:</strong> {{ $auction->material ?? '-' }}</p>
                    <p><strong>Dimensi:</strong>
                        Tinggi: {{ $auction->height ?? '-' }} cm,
                        Lebar: {{ $auction->width ?? '-' }} cm
                    </p>
                    <p><strong>Berat:</strong> {{ $auction->weight ? $auction->weight . ' kg' : '-' }}</p>
                    <p><strong>Asal Daerah:</strong> {{ $auction->region_of_origin ?? '-' }}</p>
                    <p><strong>Pembuat:</strong> {{ $auction->maker ?? '-' }}</p>
                    <p><strong>Tingkat Kelangkaan:</strong> {{ $auction->rarity_level ?? '-' }}</p>
                    <p><strong>Sertifikat Keaslian:</strong> {{ $auction->authenticity_certificate ?? '-' }}</p>

                    @if ($auction->authenticity_certificate_images)
                        <p><strong>Gambar Sertifikat:</strong></p>
                        <img src="{{ asset('storage/' . $auction->authenticity_certificate_images) }}" width="200" class="mb-3">
                    @endif

                    <p><strong>Informasi Restorasi:</strong> {{ $auction->restoration_info ?? '-' }}</p>
                    <p><strong>Provenance / Riwayat Kepemilikan:</strong> {{ $auction->provenance ?? '-' }}</p>
                    <p><strong>Kategori:</strong> {{ $auction->category ?? '-' }}</p>
                    <p><strong>Catatan Kerusakan:</strong> {{ $auction->damage_notes ?? '-' }}</p>
                </div>

                <hr class="my-4">

                <div>
                    <p><strong>Lokasi Pengiriman:</strong> {{ $auction->shipping_locations ?? '-' }}</p>
                    <p><strong>Opsi Pengiriman:</strong> {{ $auction->shipping_cost ?? '-' }}</p>
                    <p><strong>Kebijakan Retur:</strong> {{ $auction->returns_package ?? '-' }}</p>
                </div>

                <button class="btn btn-primary mt-4">
                    <a href="{{ route('customer.auctions.index') }}" class="text-white">Kembali ke daftar lelang</a>
                </button>
            </div>
        </div>
    </div>
@endsection
