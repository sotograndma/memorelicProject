@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="d-flex justify-content-between">

                <!-- Kiri: Gambar dan Deskripsi -->
                <div class="bg_jual-beli me-3">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Gambar Produk -->
                        <div class="w-full md:w-1/2">
                            <div class="border rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex gap-2 mt-2">
                                <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}"
                                    class="w-20 h-20 border rounded-lg object-cover">
                            </div>
                        </div>

                        <!-- Informasi Produk -->
                        <div class="w-full md:w-1/2">
                            <p class="fs-5 fw-bold">{{ $auction->name }}</p>
                            <p class="mt-3">Highest Bidder: <strong class="fw-bold">
                                {{ optional($auction->highestBidder)->name ?? 'No bid yet' }}</strong>
                            </p>

                            <p class="">Starting Price: <span class="fw-bold">Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</span></p>
                            <p class="">Highest Bid: <span class="fw-bold">Rp {{ number_format($auction->highest_bid, 0, ',', '.') }}</span></p>

                            <ul class="nav nav-underline mt-4" id="auction-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active color_main" id="description-tab" data-bs-toggle="pill" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link color_main" id="detail-tab" data-bs-toggle="pill" data-bs-target="#detail" type="button" role="tab" aria-controls="detail" aria-selected="true">Detail</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link color_main" id="specification-tab" data-bs-toggle="pill" data-bs-target="#specification" type="button" role="tab" aria-controls="specification" aria-selected="true">Specification</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link color_main" id="status-tab" data-bs-toggle="pill" data-bs-target="#status" type="button" role="tab" aria-controls="status" aria-selected="false">Status</button>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="auction-tabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <p class="main_color">{{ $auction->description }}</p>
                                </div>
                                <div class="tab-pane fade show active" id="detail" role="tabpanel">

                                </div>
                                <div class="tab-pane fade show active" id="specification" role="tabpanel">

                                </div>
                                <div class="tab-pane fade" id="status" role="tabpanel">
                                    <p class="main_color">Status Lelang:
                                        @if ($auction->status == 'ongoing')
                                            <span class="text-green-500 fw-bold">Sedang Berlangsung</span>
                                        @elseif ($auction->status == 'ended')
                                            <span class="text-red-500 fw-bold">Lelang Selesai</span>
                                        @elseif ($auction->status == 'sold')
                                            <span class="text-neutral-700 fw-bold">Barang Terjual</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Panel Info Ringkas -->
                <div class="bg_main text-white p-4" style="border-radius: 10px">
                    <p class="fw-bold fs-3 text-white">Rp {{ number_format($auction->highest_bid, 0, ',', '.') }}</p>

                    <div class="mt-3">
                        <p class="">Highest Bid by: <span class="fw-bold">{{ optional($auction->highestBidder)->name ?? 'Belum ada bidder' }}</span></p>
                    </div>
                    <p class="text-light">Status:
                        @if ($auction->status == 'ongoing')
                            <span class="fw-bold text-green-300">Sedang Berlangsung</span>
                        @elseif ($auction->status == 'ended')
                            <span class="fw-bold text-red-300">Selesai</span>
                        @elseif ($auction->status == 'sold')
                            <span class="fw-bold text-neutral-300">Terjual</span>
                        @endif
                    </p>
                    
                    <div class="my-4"><hr></div>
                    
                    <!-- Bid User -->
                    @php
                        $userBid = $auction->bids->where('customer_id', auth()->user()->userable_id)->sortByDesc('bid_amount')->first();
                    @endphp
                    <div class="mt-3">
                        @if ($userBid)
                            <p class="text-white">Bid Anda: <strong>Rp {{ number_format($userBid->bid_amount, 0, ',', '.') }}</strong></p>
                        @else
                            <p class="text-white">Anda belum pernah melakukan bid pada lelang ini.</p>
                        @endif
                    </div>

                    <!-- Tombol Bid -->
                    @if ($auction->status == 'ongoing')
                        <a href="{{ route('customer.bids.create', $auction->id) }}" style="width: 100%;font-size: 0.85em;" class="btn btn-main mt-3">Bid Barang</a>
                    @endif

                    <!-- Link ke riwayat bid -->
                    <div class="mt-3">
                        <a href="{{ route('customer.bids.list') }}" style="font-size: 0.85em;" class="underline text-white">Lihat Daftar Bid Anda</a>
                    </div>

                    <div class="my-4"><hr></div>

                    <div class="d-flex gap">
                        <button style="font-size: 0.85em; width: 100%;"  class="btn btn-danger mt-2 me-2 w-100">
                            <div class="d-flex gap-2 align-items-center justify-content-center">
                                <i class="bi bi-heart-fill"></i> Wishlist
                            </div>
                        </button>
                        <button style="font-size: 0.85em; width: 100%;"  class="btn btn-warning mt-2 w-100">
                            <div class="d-flex gap-2 align-items-center justify-content-center">
                                <i class="bi bi-share-fill"></i> Share
                            </div>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div style="height: 800px"></div>
@endsection
