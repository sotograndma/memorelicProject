<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - Memorelic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/customer_sidebar.css') }}">
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("-translate-x-full");
        }
    </script>
</head>

<body>

    <div class="sidebar">
        <ul class="nav flex-column">

            <div style="margin-bottom: 40px" class="px-3 pt-5">
                <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold">memorelic</a>
            </div>

            <p class="mb-2 px-3 fw-medium">HALAMAN JUAL/LELANG</p>

            <li class="nav-item mb-2">
                <a href="{{ route('customer.items.index') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-box-arrow-in-up me-2"></i> Jual Barang
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('customer.auctions.index') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-box-arrow-in-down me-2"></i> Lelang Barang
                </a>
            </li>

            <li class="nav-item mb-5">
                <a href="{{ route('customer.sold.items') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-bag-check me-2"></i> Barang Terjual
                </a>
            </li>

            <p class="mb-2 px-3 fw-medium">HALAMAN PEMBELIAN/BID</p>

            <li class="nav-item mb-2">
                <a href="{{ route('customer.orders.index') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-cart me-2"></i> Beli Barang
                </a>
            </li>

            <li class="nav-item mb-5">
                <a href="{{ route('customer.bids.index') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-currency-exchange me-2"></i> Bid Barang
                </a>
            </li>

            <p class="mb-2 px-3 fw-medium">SAYA</p>

            <li class="nav-item mb-2">
                <a href="{{ route('profile.edit') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-person-circle me-2"></i> Profil
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('logout') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>

        </ul>
    </div>

    {{-- <!-- Tombol toggle untuk mobile -->
    <button onclick="toggleSidebar()" class="md:hidden fixed top-4 left-4 bg-gray-800 text-white p-2 rounded z-50">
        ☰
    </button> --}}

    <div>
        <div class="content-wrapper p-3">
            <div class="d-flex flex-column" style="min-height: calc(100vh - 33px);">
                <div style="width: 100%; height: fit-content; background-color:rgb(228, 228, 228);border-radius:10px"
                    class="p-4 flex-grow-1">

                    <div class="topbar">
                        <div class="d-flex align-items-center justify-content-between">
                            <p>memorelic</p>
                            <p>Jual | Lelang</p>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

</body>

</html>
