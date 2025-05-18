@extends('customer.dashboard')

@section('content')
    
    <div id="home" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item carousel-item_navbar active" data-bs-interval="10000">
                <img src="/image/1.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item carousel-item_navbar" data-bs-interval="2000">
                <img src="/image/1.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item carousel-item_navbar">
                <img src="/image/1.png" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#home" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#home" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="color_main d-flex justify-content-between px-2 p-3 mt-3">
                <p class="fw-bold fs-4">Category</p>
            </div>

            <div class="d-flex justify-content-between">
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 200px;" src="/image/category/koleksi.png" alt="">
                    <p class="mt-3 fs-6 main_color fw-medium">Antik & Koleksi Kuno</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 200px;" src="/image/category/jam.png" alt="">
                    <p class="mt-3 fs-6 main_color fw-medium">Jam Antik & Aksesoris Waktu</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 200px;" src="/image/category/radio.png" alt="">
                    <p class="mt-3 fs-6 main_color fw-medium">Elektronik & Radio Vintage</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 200px;" src="/image/category/kursi.png" alt="">
                    <p class="mt-3 fs-6 main_color fw-medium">Furnitur & Dekorasi Antik</p>
                </div>
                <div class="p-3 bg_category text-center">
                    <img class="w-100" style="max-width: 200px;" src="/image/category/kris.png" alt="">
                    <p class="mt-3 fs-6 main_color fw-medium">Senjata & Peralatan Tradisional</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="color_main d-flex justify-content-center px-2 p-3 mt-3">
                <p class="fw-bold fs-4">Ongoing Highest Bid</p>
            </div>

            <div class="d-flex justify-content-between">
                    <div id="home" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item carousel-item_navbar active" data-bs-interval="10000">
                                <img src="/image/1.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item carousel-item_navbar" data-bs-interval="2000">
                                <img src="/image/1.png" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item carousel-item_navbar">
                                <img src="/image/1.png" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#home" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#home" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            <div class="color_main d-flex justify-content-between px-2 p-3 mt-3">
                <p class="fw-bold fs-4">Most Purchase</p>
                <a style="font-style: italic; font-size: 0.8em">see all</a>
            </div>

            <div class="d-flex justify-content-between">
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 500px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 500px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 500px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category me-3 text-center">
                    <img class="w-100" style="max-width: 500px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
                <div class="p-3 bg_category text-center">
                    <img class="w-100" style="max-width: 500px;" src="/image/3.png" alt="">
                    <p class="mt-3 fw-medium">lorem ipsum</p>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 1000px"></div>

@endsection
