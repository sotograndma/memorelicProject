<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('image/hootbert/hootbert_half.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
    </style>
</head>

<body>

    <div class="sidebar">
        <ul class="nav flex-column">

            <div style="margin-bottom: 40px" class="px-3 pt-5">
                <h4 class="text-white fw-semibold">memorelic <br> Admin Panel</h4>
            </div>

            <li class="nav-item mb-2">
                <a href="{{ route('admin.users.index') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-people me-2"></i> Manajemen Akun
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('admin.users.create.admin') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-person-plus me-2"></i> Tambah Admin
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('admin.users.create.customer') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Customer
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('admin.couriers.index') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-truck me-2"></i> Kurir
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('logout') }}" class="nav-link d-flex align-items-center">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>

        </ul>
    </div>

    <div>
        <div class="content-wrapper p-3">
            <div class="d-flex flex-column" style="min-height: calc(100vh - 33px);">
                <div style="width: 100%; height: fit-content; background-color:rgb(228, 228, 228);border-radius:10px"
                    class="p-4 flex-grow-1">

                    <div class="topbar">
                        <div class="d-flex align-items-center justify-content-between">
                            <p>memorelic</p>
                            <p>Admin</p>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

</body>

</html>
