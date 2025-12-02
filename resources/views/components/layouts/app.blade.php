<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kasir Digital') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: #f5f7fa;
            font-family: "Nunito", sans-serif;
        }

        /* Navbar Glass Effect */
        .nav-glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.75) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Navigation Buttons */
        .menu-btn {
            border-radius: 12px;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .menu-btn:hover {
            transform: translateY(-2px);
        }

        /* Active button */
        .menu-active {
            background: #0d6efd;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        }

        /* Page container */
        .content-wrapper {
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div id="app">

        <!-- Modern Navbar -->
        <nav class="navbar navbar-expand-md navbar-light nav-glass sticky-top py-3">
            <div class="container">

                <a class="navbar-brand fw-bold fs-4" href="{{ url('/home') }}">
                    {{ config('app.name', 'Kasir Digital') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('login') }}">Login</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('register') }}">Register</a>
                        </li>
                        @endif

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle fw-semibold" href="#" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end shadow-sm rounded">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>

            </div>
        </nav>

        <!-- Navigation Menu -->
        <main class="content-wrapper">
            <div class="container mb-4">
                <div class="d-flex flex-wrap gap-2">

                    <a href="{{ route('home') }}"
                        class="btn menu-btn {{ request()->routeIs('home') ? 'menu-active' : 'btn-outline-primary' }}">
                        Beranda
                    </a>

                    <a href="{{ route('user') }}"
                        class="btn menu-btn {{ request()->routeIs('user') ? 'menu-active' : 'btn-outline-primary' }}">
                        Pengguna
                    </a>

                    <a href="{{ route('produk') }}"
                        class="btn menu-btn {{ request()->routeIs('produk') ? 'menu-active' : 'btn-outline-primary' }}">
                        Produk
                    </a>

                    <a href="{{ route('transaksi') }}"
                        class="btn menu-btn {{ request()->routeIs('transaksi') ? 'menu-active' : 'btn-outline-primary' }}">
                        Transaksi
                    </a>

                    <a href="{{ route('laporan') }}"
                        class="btn menu-btn {{ request()->routeIs('laporan') ? 'menu-active' : 'btn-outline-primary' }}">
                        Laporan
                    </a>
                </div>
            </div>

            <div class="container">
                {{ $slot }}
            </div>
        </main>

    </div>
</body>
</html>
