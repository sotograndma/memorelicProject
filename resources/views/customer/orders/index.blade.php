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
                        <p class="fs-1 fw-bold color_maroon mb-3">Temukan Harta Karun<br>dari Masa Lalu</p>
                        
                        <p style="width: 700px" class="color_dark">
                            Setiap barang punya cerita. Jelajahi koleksi barang antik yang tersedia, dari jam kuno hingga dekorasi penuh sejarah, dan rasakan sensasi berburu harta karun yang tak ternilai.
                            <span class="color_maroon fw-bold">Siapa tahu, barang impianmu menunggu di sini.</span>
                        </p>

                        <div class="d-flex mt-4">
                            <a href="{{ $isVerified ? route('customer.items.index') : route('seller.verification.prompt') }}"
                                class="btn btn_maroon me-3">Mulai Jual Barang Anda</a>
                            <a href="#mostViewed" class="btn btn_cream">Lihat Seluruh Barang</a>
                        </div>
                    </div>
                    <img style="position: relative; top: 24px; width: 250px; !important;" src="/image/hootbert/hootbert_half.png" alt="Mulai jualan">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <ul class="nav nav-underline nav-justified" id="categoryTabs" role="tablist">
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
                            id="tab-{{ $key }}" 
                            data-bs-toggle="tab" 
                            data-bs-target="#pane-{{ $key }}" 
                            type="button" 
                            role="tab" 
                            aria-controls="pane-{{ $key }}" 
                            aria-selected="{{ $first ? 'true' : 'false' }}">
                            {{-- <img src="{{ $cat['img'] }}" style="max-width: 60px;" class="mb-2"> --}}
                            <span>{{ $cat['label'] }}</span>
                        </button>
                    </li>
                    @php $first = false; @endphp
                @endforeach
            </ul>

            <div class="tab-content mt-4" id="categoryTabContent">
                @php $first = true; @endphp
                @foreach($categories as $key => $cat)
                    <div class="tab-pane fade {{ $first ? 'show active' : '' }}" id="pane-{{ $key }}" role="tabpanel" aria-labelledby="tab-{{ $key }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($items->where('category', $key) as $item)
                                <div class="bg_category">
                                    <a href="{{ route('customer.orders.show', $item->id) }}">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                            class="w-full h-48 object-cover rounded-lg">
                                    </a>

                                    <p class="fs-5 mt-2 truncate">{{ $item->name }}</p>

                                    <p class="fw-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                                    <p class="text-sm text-gray-500 flex items-center mt-4">
                                        {{ $item->shipping_locations ?? '-' }}
                                    </p>

                                    @php
                                        $averageRating = round($item->reviews->avg('rating'), 1);
                                        $totalRating = $item->reviews->count();
                                    @endphp

                                    <p class="text-neutral-500">
                                        Terjual {{ $item->sold_count }} | 
                                        {{ $averageRating }} 
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $averageRating ? 'bi-star-fill text-warning' : 'bi-star text-warning' }}"></i>
                                        @endfor
                                        ({{ $totalRating }} rating)
                                    </p>

                                    <div class="mt-4 d-flex justify-content-end">
                                        <a href="{{ route('customer.orders.show', $item->id) }}"
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

    <div id="#mostViewed" class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="color_dark d-flex align-items-end justify-content-betstartween px-2 p-3">
                <p class="fw-bold fs-6">All Items</p>
                {{-- <a style="font-style: italic; font-size: 0.8em"></a> --}}
            </div>

            @if (session('success'))
                <div class="bg-green-400 text-white p-2 mt-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($items as $item)
                    @if ($item->status == 'available')

                        <div class="bg_category">
                            <a href="{{ route('customer.orders.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                    class="w-full h-48 object-cover rounded-lg">
                            </a>

                            <p class="fs-5 mt-2 truncate">{{ $item->name }}</p>

                            <p class="fw-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                            <p class="text-sm text-gray-500 flex items-center mt-4">
                                {{ $item->shipping_locations ?? '-' }}
                            </p>

                            @php
                                $averageRating = round($item->reviews->avg('rating'), 1);
                                $totalRating = $item->reviews->count();
                            @endphp

                            <p class="text-neutral-500">
                                Terjual {{ $item->sold_count }} | 
                                {{ $averageRating }} 
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $averageRating ? 'bi-star-fill text-warning' : 'bi-star text-warning' }}"></i>
                                @endfor
                                ({{ $totalRating }} rating)
                            </p>

                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('customer.orders.show', $item->id) }}"
                                    style="font-size: 0.85em" class="btn btn_maroon">Lihat</a>
                            </div>
                        </div>

                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <ul class="nav nav-underline nav-justified" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active color_dark" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Recommended for You</button>
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
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
            </div>
        </div>
    </div> --}}

    <div style="height: 500px"></div>
    
@endsection
