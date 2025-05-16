@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div style="color: white;border-radius:10px" class="bg_jualLelang p-5">
                <p class="fw-bold fs-1">Timeless Treasures Await</p>
                <p style="font-style: italic">Explore handpicked antiques from passionate collectors around the world.</p>
                <div class="mt-5">
                    <a href="#mostViewed"><button class="btn btn-main me-3">Browse All Listings</button></a>
                    <button class="btn btn-mainOutline">Start Your Collection</button>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="color_main d-flex align-items-end justify-content-start px-2 p-3">
                <p class="fw-bold fs-5 me-3">Category</p>
                <a style="font-style: italic; font-size: 0.8em">see all</a>
            </div>

            <div class="d-flex justify-content-between">
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="height: 150px; width: 150px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="height: 150px; width: 150px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="height: 150px; width: 150px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="height: 150px; width: 150px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="height: 150px; width: 150px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category text-center">
                    <img class="w-100" style="height: 150px; width: 150px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
            </div>
        </div>
    </div>

    <div id="mostViewed" class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="color_main d-flex align-items-end justify-content-betstartween px-2 p-3">
                <p class="fw-bold fs-5 me-3">Most Viewed</p>
                <a style="font-style: italic; font-size: 0.8em">see all</a>
            </div>

            @if (session('success'))
                <div class="bg-green-400 text-white p-2 mt-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($items as $item)
                    @if ($item->status == 'available')

                        <div class="bg_jual-beli">
                            <a href="{{ route('customer.orders.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                    class="w-full h-48 object-cover rounded-lg">
                            </a>

                            <p class="fs-5 mt-2 truncate">{{ $item->name }}</p>

                            <p class="fw-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                            <p class="text-sm text-gray-500 flex items-center mt-4">
                                Jakarta, Indonesia
                            </p>

                            <p class="text-sm text-gray-500 flex items-center mt-1">
                                4.9 | 500+ terjual
                            </p>

                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('customer.orders.show', $item->id) }}"
                                    style="font-size: 0.85em" class="btn btn-main">Lihat</a>
                            </div>
                        </div>

                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <ul class="nav nav-underline nav-justified" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active color_main" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Recommended for You</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link color_main" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Just Added</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
                </li> --}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                    @if (session('success'))
                        <div class="bg-green-400 text-white p-2 mt-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
                        @foreach ($items as $item)
                            @if ($item->status == 'available')

                                <div class="bg_jual-beli">
                                    <a href="{{ route('customer.orders.show', $item->id) }}">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                            class="w-full h-48 object-cover rounded-lg">
                                    </a>

                                    <p class="fs-5 mt-2 truncate">{{ $item->name }}</p>

                                    <p class="fw-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                                    <p class="text-sm text-gray-500 flex items-center mt-4">
                                        Jakarta, Indonesia
                                    </p>

                                    <p class="text-sm text-gray-500 flex items-center mt-1">
                                        4.9 | 500+ terjual
                                    </p>

                                    <div class="mt-4 d-flex justify-content-end">
                                        <a href="{{ route('customer.orders.show', $item->id) }}"
                                        style="font-size: 0.85em" class="btn btn-main">Lihat</a>
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    </div>

                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                    

                </div>
                {{-- <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div> --}}
            </div>
        </div>
    </div>

    <div style="height: 500px"></div>
    
@endsection
