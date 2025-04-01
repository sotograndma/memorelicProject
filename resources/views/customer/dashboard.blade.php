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
    <link rel="stylesheet" href="{{ asset('css/customer_navbar.css') }}">
</head>

<body>

    <div class="p-3">
        <div class="topbar">
            <div class="d-flex align-items-center justify-between px-2">
                <a href="{{ route('customer.dashboard') }}" class="text-lg font-bold">Memorelic</a>
                <ul class="flex space-x-1 items-center">

                    <li class="relative">
                        <button onclick="toggleDropdown('barangDropdown')" class="text-white px-4 py-2 rounded ">
                            Jual / Lelang ▼
                        </button>
                        <ul id="barangDropdown"
                            class="hidden absolute bg_dropdown text-white rounded shadow-lg mt-2 w-48 z-50">
                            <li><a href="{{ route('customer.items.index') }}"
                                    class="block px-4 py-2 bg_dropdownSelect">Jual Barang</a></li>
                            <li><a href="{{ route('customer.auctions.index') }}"
                                    class="block px-4 py-2 bg_dropdownSelect">Lelang Barang</a></li>
                            <li><a href="{{ route('customer.sold.items') }}"
                                    class="block px-4 py-2 bg_dropdownSelect">Barang Terjual</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('customer.orders.index') }}" class="block px-4 py-2">Beli
                            Barang</a></li>

                    <li class="relative">
                        <button onclick="toggleDropdown('bidDropdown')" class="text-white px-4 py-2 rounded ">
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

                    <li><a href="{{ route('customer.transactions.history') }}" class="block px-4 py-2">Riwayat
                            Transaksi</a></li>

                    <li class="relative">
                        <button onclick="toggleDropdown('akunDropdown')" class="text-white px-4 py-2 rounded ">
                            Akun ▼
                        </button>
                        <ul id="akunDropdown"
                            class="hidden absolute bg_dropdown text-white rounded shadow-lg mt-2 w-40 z-50">
                            <li><a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 bg_dropdownSelect">Profil</a></li>
                            <li><a href="{{ route('logout') }}" class="block px-4 py-2 bg_dropdownSelect">Logout</a>
                            </li>
                        </ul>
                    </li>

                </ul>
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

    @yield('content')
</body>

</html>
