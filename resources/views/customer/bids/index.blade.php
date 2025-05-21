@extends('customer.dashboard')

@section('content')

    @php
        $isVerified = Auth::user()->userable->is_verified_seller ?? false;
    @endphp

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div style="border: 0px" class="bg_cream p-4 text-white rounded-xl">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <p class="fs-1 fw-bold color_maroon mb-3">Temukan Barang Antik<br>Lewat Lelang</p>
                        
                        <p style="width: 700px" class="color_dark">
                            Setiap tawaran membawamu lebih dekat pada harta karun bersejarah. Ikuti proses lelang yang transparan dan menegangkan—dari koleksi langka hingga benda bersejarah bernilai tinggi. 
                            <span class="color_maroon fw-bold">Jangan lewatkan, mungkin barang incaranmu akan jatuh ke tanganmu hari ini!</span>
                        </p>

                        <div class="d-flex mt-4">
                            <a href="{{ $isVerified ? route('customer.auctions.index') : route('seller.verification.prompt') }}"
                                class="btn btn_maroon me-3">Mulai Lelang Barang Anda</a>
                            <a href="#mostViewed" class="btn btn_cream">Lihat Semua Lelang</a>
                        </div>
                    </div>
                    <img style="position: relative; top: 24px; width: 250px; !important;" src="/image/hootbert/hootbert_half.png" alt="Mulai jualan">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <ul class="nav nav-underline nav-justified" id="auctionTabs" role="tablist">
                @php
                    $categories = [
                        'Collectibles' => ['label' => 'Antik & Koleksi Kuno', 'img' => '/image/category/koleksi.png'],
                        'Accessories' => ['label' => 'Jam Antik & Aksesoris Waktu', 'img' => '/image/category/jam.png'],
                        'Electronics' => ['label' => 'Elektronik & Radio Vintage', 'img' => '/image/category/radio.png'],
                        'Furniture' => ['label' => 'Furnitur & Dekorasi Antik', 'img' => '/image/category/kursi.png'],
                        'Traditional Weapons' => ['label' => 'Senjata & Peralatan Tradisional', 'img' => '/image/category/kris.png'],
                    ];
                    $first = true;
                @endphp

                @foreach($categories as $key => $cat)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $first ? 'active' : '' }} color_dark d-flex flex-column align-items-center"
                            id="auction-tab-{{ $key }}"
                            data-bs-toggle="tab"
                            data-bs-target="#auction-pane-{{ $key }}"
                            type="button"
                            role="tab"
                            aria-controls="auction-pane-{{ $key }}"
                            aria-selected="{{ $first ? 'true' : 'false' }}">
                            {{-- <img src="{{ $cat['img'] }}" style="max-width: 60px;" class="mb-2"> --}}
                            <span>{{ $cat['label'] }}</span>
                        </button>
                    </li>
                    @php $first = false; @endphp
                @endforeach
            </ul>

            <div class="tab-content mt-4" id="auctionTabContent">
                @php $first = true; @endphp
                @foreach($categories as $key => $cat)
                    <div class="tab-pane fade {{ $first ? 'show active' : '' }}" id="auction-pane-{{ $key }}" role="tabpanel" aria-labelledby="auction-tab-{{ $key }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($auctions->where('category', $key) as $auction)
                                <div class="bg_category">
                                    <a href="{{ route('customer.bids.show', $auction->id) }}">
                                        <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}"
                                            class="w-full h-48 object-cover rounded-lg">
                                    </a>

                                    <p class="fs-5 mt-2 truncate">{{ $auction->name }}</p>

                                    <p class="fw-bold">Harga Awal: Rp
                                        {{ number_format($auction->starting_bid, 0, ',', '.') }}</p>

                                    <p class="text-sm text-gray-500 flex items-center mt-4">
                                        Mulai: {{ date('d M Y H:i', strtotime($auction->start_time)) }}
                                    </p>
                                    <p class="text-sm text-gray-500 flex items-center mt-1">
                                        Berakhir: {{ date('d M Y H:i', strtotime($auction->end_time)) }}
                                    </p>

                                    <div class="mt-4 d-flex justify-content-end">
                                        <a href="{{ route('customer.bids.show', $auction->id) }}"
                                            style="font-size: 0.85em" class="btn btn_maroon">Lihat</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @php $first = false; @endphp
                @endforeach
            </div>
        </div>
    </div>


    <div id="mostViewed" class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="color_dark d-flex align-items-end justify-content-betstartween px-2 p-3">
                <p class="fw-bold fs-6">All Auctions</p>
                {{-- <a style="font-style: italic; font-size: 0.8em">see all</a> --}}
            </div>

            @if (session('success'))
                <div class="bg-green-500 text-white p-3 mt-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($auctions as $auction)
                    <div class="bg_category">
                        <a href="{{ route('customer.bids.show', $auction->id) }}">
                            <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->name }}"
                                class="w-full h-48 object-cover rounded-lg">
                        </a>

                        <p class="fs-5 mt-2 truncate">{{ $auction->name }}</p>

                        <p class="fw-bold">Harga Awal: Rp
                            {{ number_format($auction->starting_bid, 0, ',', '.') }}</p>

                        <p class="text-sm text-gray-500 flex items-center mt-4">
                            Mulai: {{ date('d M Y H:i', strtotime($auction->start_time)) }}
                        </p>
                        <p class="text-sm text-gray-500 flex items-center mt-1">
                            Berakhir: {{ date('d M Y H:i', strtotime($auction->end_time)) }}
                        </p>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('customer.bids.show', $auction->id) }}"
                                style="font-size: 0.85em" class="btn btn_maroon">Lihat</a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <ul class="nav nav-underline nav-justified" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active color_dark" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Frequently Searched Items</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link color_dark" id="allLive-tab" data-bs-toggle="tab" data-bs-target="#allLive-tab-pane" type="button" role="tab" aria-controls="allLive-tab-pane" aria-selected="true">All Active Auctions</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link color_dark" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Just Added</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                </div>
                <div class="tab-pane fade" id="allLive-tab-pane" role="tabpanel" aria-labelledby="allLive-tab" tabindex="0">
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
            </div>
        </div>
    </div> --}}

    <div style="height: 800px"></div>
@endsection
