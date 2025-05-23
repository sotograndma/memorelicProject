<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - Memorelic</title>
    <link rel="icon" type="image/png" href="{{ asset('image/hootbert/hootbert_half.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/customer_navbar.css') }}">
</head>

<body>
    <div class="d-flex justify-center">
        <div class="topbar">
            <div class="d-flex align-items-center justify-between px-2 p-3">
                <div class="d-flex align-items-center">
                    <a href="{{ route('customer.dashboard') }}" class="text-lg font-bold me-5">Memorelic</a>
                    <div style="width: 800px" class="w-full">
                        <div class="flex items-center border rounded-md px-3 py-2 shadow-sm bg_main">
                            <input
                                type="text"
                                placeholder="What can we help you find today?"
                                class="w-full bg-transparent focus:outline-none text-sm text-neutral-100 placeholder-neutral-600"
                            />

                            <svg class="w-5 h-5 text-neutral-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <ul class="flex space-x-1 items-center">

                    
                    <li class="d-flex align-items-center px-4 py-2">
                        <i class="bi bi-heart me-2"></i>
                        <a href="{{ route('customer.wishlist.index') }}" class="block">Favorites</a>
                    </li>

                    <li class="d-flex align-items-center px-4 py-2">
                        <i class="bi bi-cart me-2"></i>
                        <a href="{{ route('customer.cart.view') }}" class="block">My Cart</a>
                    </li>
                    
                    <li class="relative px-4 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle me-2"></i>
                            <button onclick="toggleDropdown('akunDropdown')" class="text-white rounded">
                                {{ Auth::user()->name }} ▼
                            </button>
                        </div>
                        
                        <ul id="akunDropdown"
                            class="hidden absolute bg_dropdown text-white rounded shadow-lg mt-2 w-40 z-50">
                            <li><a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 bg_dropdownSelect">Profil</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 bg_dropdownSelect text-left w-full">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            
            <div class="px-2 py-2">
                <hr>
            </div>

            <div class="d-flex justify-content-between px-2 p-3">
                <div class="d-flex">
                    <li><a href="{{ route('customer.home') }}" class="block me-5">Home</a></li>

                    <li class="relative">
                        <button onclick="toggleDropdown('barangDropdown')" class="text-white rounded me-5">
                            Jual / Lelang ▼
                        </button>

                        {{-- buka comment ini kalau mau liat loading screen --}}
                        {{-- @php $isVerified = Auth::user()->is_verified_seller; @endphp --}}

                        @php
                            $customer = Auth::user()->userable;
                            $isVerified = $customer && $customer->is_verified_seller;
                        @endphp


                        <ul id="barangDropdown" class="hidden absolute bg_dropdown text-white rounded shadow-lg mt-2 w-48 z-50">
                            <li>
                                <a href="{{ $isVerified ? route('customer.items.index') : route('seller.verification.prompt') }}"
                                class="block px-4 py-2 bg_dropdownSelect">Jual Barang</a>
                            </li>
                            <li>
                                <a href="{{ $isVerified ? route('customer.auctions.index') : route('seller.verification.prompt') }}"
                                class="block px-4 py-2 bg_dropdownSelect">Lelang Barang</a>
                            </li>
                            <li>
                                <a href="{{ $isVerified ? route('customer.sold.items') : route('seller.verification.prompt') }}"
                                class="block px-4 py-2 bg_dropdownSelect">Barang Terjual</a>
                            </li>
                            <li>
                                <a href="{{ $isVerified ? route('customer.transactions.manage') : route('seller.verification.prompt') }}"
                                class="block px-4 py-2 bg_dropdownSelect">Kelola Pengiriman</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="{{ route('customer.orders.index') }}" class="block me-5">Beli
                            Barang</a></li>

                    <li class="relative">
                        <button onclick="toggleDropdown('bidDropdown')" class="text-white me-5 rounded">
                            Bid ▼
                        </button>
                        <ul id="bidDropdown"
                            class="hidden absolute bg_dropdown text-white rounded shadow-lg mt-2 w-56 z-50">

                            <li><a href="{{ route('customer.bids.index') }}"
                                    class="block px-4 py-2 bg_dropdownSelect">Bid Barang</a></li>
                            <li><a href="{{ route('customer.bids.list') }}"
                                    class="block px-4 py-2 bg_dropdownSelect">Daftar Bid</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('customer.transactions.history') }}" class="block me-5">Riwayat
                            Transaksi</a></li>
                    
                    <li><a href="{{ route('customer.aboutus') }}" class="block me-5">About Us</a></li>

                </div>
                <div>
                    <li>
                        <a href="" class="block">
                            Deliver To: 
                            <span class="fw-bold">
                                {{ Auth::user()->userable->locations ?? 'Lokasi belum diatur' }}
                            </span>
                        </a>
                    </li>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            // Tutup semua dropdown dulu
            document.querySelectorAll('ul[id$="Dropdown"]').forEach(el => {
                if (el.id !== id) {
                    el.classList.add('hidden');
                }
            });

            // Toggle dropdown yang dipilih
            const menu = document.getElementById(id);
            menu.classList.toggle('hidden');
        }

        // Optional: Tutup dropdown saat klik di luar
        window.addEventListener('click', function(e) {
            document.querySelectorAll('ul[id$="Dropdown"]').forEach(el => {
                if (!el.previousElementSibling.contains(e.target) && !el.contains(e.target)) {
                    el.classList.add('hidden');
                }
            });
        });
    </script>

    <script>
        document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
        const faqItem = button.parentElement;
        const isActive = faqItem.classList.contains('active');

        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });

                if (!isActive) {
                    faqItem.classList.add('active');
                }
            });
        });
    </script>

    <script>
        function copyLink() {
            const dummy = document.createElement('input');
            dummy.value = window.location.href;
            document.body.appendChild(dummy);
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            alert('Link halaman berhasil disalin!');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    

    @yield('content')

    <div class="rounded-xl p-2">
        <footer class="bg_dark text-white mt-5 p-5">
            <div class="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <p class="fw-bold fs-1">Memorelic</p>
                        <p class="italic">Koleksi barang antik, langka, dan penuh sejarah. Temukan cerita di balik setiap benda.</p>
                    </div>
                </div>
                <hr class="my-5">
                <div class="text-center italic">
                    <small>© {{ date('Y') }} Memorelic. All rights reserved.</small>
                </div>
            </div>
        </footer>
    </div>

</body>

</html>
