@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">

            <div class="d-flex justify-content-between">

                <div class="bg_jual-beli me-3">
                    <div class="flex flex-col md:flex-row gap-6">
    
                        <!-- Gambar Produk -->
                        <div class="w-full md:w-1/2">
                            <div class="border rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex gap-2 mt-2">
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                    class="w-20 h-20 border rounded-lg object-cover">
                            </div>
                        </div>
    
                        <!-- Informasi Produk -->
                        <div class="w-full md:w-1/2">
                            <p class="fs-5">{{ $item->name }}</p>
                            <p class="text-neutral-500">Terjual {{ $item->sold_count }} | 5 (166 rating)</p>
    
                            <p class="fw-bold mt-3 fs-2 main_color">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
    
                            <ul class="nav nav-underline mt-4" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active color_main" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link color_main" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Detail</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link color_main" id="pills-Specification-tab" data-bs-toggle="pill" data-bs-target="#pills-Specification" type="button" role="tab" aria-controls="pills-Specification" aria-selected="false">Specification</button>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                    <p class="main_color">{{ $item->description }}</p>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                    <li><strong>Kategori:</strong> {{ $item->category ?? '-' }}</li>
                                    <li><strong>Tingkat Kelangkaan:</strong> {{ $item->rarity_level ?? '-' }}</li>
                                    <li><strong>Catatan Kerusakan:</strong> {{ $item->damage_notes ?? '-' }}</li>

                                    <hr class="my-2" style="width: 50px">

                                    <li><strong>Tahun Pembuatan:</strong> {{ $item->year_of_origin ? \Carbon\Carbon::parse($item->year_of_origin)->translatedFormat('d F Y') : '-' }}</li>
                                    <li><strong>Wilayah / Negara Asal:</strong> {{ $item->region_of_origin ?? '-' }}</li>
                                    <li><strong>Pembuat / Pengrajin:</strong> {{ $item->maker ?? '-' }}</li>
                                    <hr class="my-2" style="width: 50px">
                                    <li><strong>Restorasi:</strong> {{ $item->restoration_info ?? '-' }}</li>
                                    <li><strong>Provenance:</strong> {{ $item->provenance ?? '-' }}</li>
                                    <hr class="my-2" style="width: 50px">
                                    <li><strong>Minimal Order:</strong> {{ $item->min_order ?? '-' }}</li>
                                </div>
                                <div class="tab-pane fade" id="pills-Specification" role="tabpanel" aria-labelledby="pills-Specification-tab" tabindex="0">
                                    <li><strong>Material:</strong> {{ $item->material ?? '-' }}</li>
                                    <li><strong>Dimensi (T x L):</strong> {{ $item->height ?? '-' }} cm x {{ $item->width ?? '-' }} cm</li>
                                    <li><strong>Berat:</strong> {{ $item->weight ?? '-' }} kg</li>
                                    <li><strong>Kondisi:</strong> {{ $item->condition ?? '-' }}</li>
                                    <hr class="my-2" style="width: 50px">
                                    <p><strong>Sertifikat Keaslian:</strong> {{ $item->authenticity_certificate ?? '-' }}</p>
                                    @if ($item->authenticity_certificate_images)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $item->authenticity_certificate_images) }}" alt="Sertifikat" width="200">
                                        </div>
                                    @endif
                                </div>
                            </div>
    
                            <!-- Info Pengiriman -->
                            <div class="mt-5 main_color">
                                <p class="fs-5 fw-bold mb-2">Shipping</p>
                                <div class="d-flex gap-2 align-items-center mt-2">
                                    <i class="bi bi-geo-alt"></i>
                                    <p class="">Sent from <span class="fw-bold">{{ $item->shipping_locations ?? '-' }}</span></p>
                                </div>
                                <div class="d-flex gap-2 align-items-center mt-2">
                                    <i class="bi bi-truck"></i>
                                    <div>
                                        <p>Shipping costs and Estimated arrival:</p>
                                        <p class="fw-bold">{{ $item->shipping_cost ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>

                <div style="border-radius: 10px" class="bg_main text-white p-4">
                    <p class="fw-bold fs-2 main_color">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    {{-- <p class="mt-1 main_color">Delivery <span class="fw-bold">Tuesday, May 27.</span></p> --}}
                    <div class="d-flex gap-2 align-items-center mt-4">
                        <i class="bi bi-geo-alt"></i>
                        <p class="">deliver to <br><span class="fw-bold underline">
                                {{ Auth::user()->userable->locations ?? 'Lokasi belum diatur' }}
                            </span></p>
                    </div>

                    <!-- Stok dan Kuantitas -->
                    <div class="mt-4">
                        @if ($item->stock > 0)
                            <p class="text-green-300 fw-bold fs-5">In Stock</p>
                            <p class="italic text-green-500">Stock: {{ $item->stock }} remaining</p>
                        @else
                            <p class="text-red-400 fw-bold fs-5">Out of Stock</p>
                        @endif
                    </div>

                    @if ($item->stock > 0)
                        <form method="GET" action="{{ route('customer.checkout', ['item_id' => $item->id]) }}">
                            <input type="hidden" name="type" value="item">

                            <div class="dropdown mt-4 d-flex bg-neutral-700 border-1 border-neutral-500"
                                style="display: inline-block; border-radius: 12px; padding: 5px 10px;width: 100%;">
                                <p class="text-neutral-400" style="margin-right: 5px;">Quantity:</p>
                                <select name="quantity" class="form-select form-select-sm text-neutral-400"
                                    style="display: inline-block; width: auto; border: none; background: transparent; padding: 0; box-shadow: none;">
                                    @for ($i = 1; $i <= min(5, $item->stock); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="my-4">
                                <hr>
                            </div>

                            <div class="mt-4">
                                <button type="submit" style="font-size: 0.85em; width: 100%;" class="btn btn-main mt-2">
                                    Buy Now
                                </button>
                            </div>
                        </form>

                    @else
                        <div class="my-4">
                            <hr>
                        </div>

                        <div class="mt-4">
                            <button disabled style="font-size: 0.85em; width: 100%;" class="btn btn-secondary mt-2">Out of Stock</button>
                        </div>
                    @endif

                    <button style="font-size: 0.85em; width: 100%;" class="btn btn-mainOutline mt-2">Add to Cart</button>

                    <div class="mt-4">
                        <table>
                            <tr>
                                <td>
                                    <p>ships from:</p>
                                </td>
                                <td>
                                    <p class="ms-4 fw-semibold">memorelic</p>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p>sold by:</p>
                                </td>
                                <td>
                                    <p class="ms-4 fw-semibold">{{ $item->customer->name ?? '-' }}</p>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p>returns:</p>
                                </td>
                                <td>
                                    <p class="ms-4 fw-semibold">{{ $item->returns_package ?? '-' }}</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="my-4">
                        <hr>
                    </div>

                    <div class="d-flex gap">
                        <button style="font-size: 0.85em; width: 100%;" class="btn btn-danger mt-2 me-2">
                            <div class="d-flex gap-2 align-items-center">
                                <i style="position: relative; top: 1px" class="bi bi-heart-fill"></i>
                                Wishlist
                            </div>
                        </button>
                        <button style="font-size: 0.85em; width: 100%;" class="btn btn-warning mt-2">
                            <div class="d-flex gap-2 align-items-center">
                                <i style="position: relative; top: 1px" class="bi bi-share-fill"></i>
                                Share
                            </div>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div style="height: 500px"></div>
@endsection
