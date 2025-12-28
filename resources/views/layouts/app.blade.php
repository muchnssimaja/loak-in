<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','LOAK.IN • Marketplace Barang Bekas')</title>

    {{-- Bootstrap 5 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet"
    />

    {{-- CSS custom (lokasi: public/assets/css/loakin.css) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/loakin.css') }}">
</head>
<body class="bg-page">

<nav class="navbar navbar-expand-lg navbar-light loakin-navbar shadow-sm">
    <div class="container">
        {{-- Logo + brand --}}
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center gap-2">
    <img src="{{ asset('assets/img/logo-loakin.png') }}" alt="LOAK.IN" height="32">
            <span class="fw-bold tracking-tight">
                LOAK<span class="text-brand-dot">•</span>IN
            </span>
        </a>

        {{-- Toggler mobile --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#loakinNavbar" aria-controls="loakinNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="loakinNavbar">
            {{-- SEARCH BAR NAVBAR --}}
            <form method="GET"
                  action="{{ route('listings.index') }}"
                  class="d-flex align-items-center loakin-nav-search my-2 my-lg-0">
                <input type="text"
                       name="q"
                       class="form-control form-control-sm me-1"
                       placeholder="Cari barang bekas..."
                       value="{{ request('q') }}">
                <button class="btn btn-outline-secondary btn-sm" type="submit">
                    Cari
                </button>
            </form>

            {{-- MAIN NAV LINKS --}}
            <ul class="navbar-nav ms-auto align-items-lg-center mb-2 mb-lg-0 loakin-nav-main">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Terbaru
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('seller.listings.index') ? 'active' : '' }}"
                           href="{{ route('seller.listings.index') }}">
                            Listing Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('seller.profile.edit') ? 'active' : '' }}"
                           href="{{ route('seller.profile.edit') }}">
                            Profil
                        </a>
                    </li>

                    {{-- Tombol Jual Barang --}}
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-brand"
                           href="{{ route('listings.create') }}">
                            Jual Barang
                        </a>
                    </li>

                    {{-- Dropdown Admin (hanya admin) --}}
                    @can('admin')
                        <li class="nav-item dropdown ms-lg-2">
                            <button class="btn btn-sm btn-admin dropdown-toggle"
                                    type="button"
                                    id="adminDropdown"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                Admin
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('admin.listings.index') }}">
                                        Semua Listing
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('admin.reports.index') }}">
                                        Laporan
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-brand"
                           href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endguest
            </ul>

            {{-- User dropdown kecil di mobile --}}
            @auth
                <div class="d-lg-none border-top mt-2 pt-2 w-100">
                    <div class="small text-muted">
                        Masuk sebagai
                    </div>
                    <div class="fw-semibold">
                        {{ Auth::user()->name }}
                        @if(Auth::user()->is_admin ?? false)
                            <span class="badge bg-success ms-1">Admin</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button class="btn btn-outline-secondary btn-sm w-100">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        {{-- User info (desktop) --}}
        @auth
            <div class="d-none d-lg-flex align-items-center ms-3 gap-2">
                <div class="text-end small me-1">
                    <div class="fw-semibold">{{ Auth::user()->name }}</div>
                    @if(Auth::user()->is_admin ?? false)
                        <div class="text-success">Admin</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-secondary btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        @endauth
    </div>
</nav>

<main class="py-4">
    <div class="container loakin-container">
        @yield('content')
    </div>
</main>

<footer class="loakin-footer mt-4 py-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2 small">
        <div>
            LOAK.IN &copy; {{ date('Y') }} • Marketplace Barang Bekas
        </div>
        <div class="text-muted">
            Dibangun dengan Laravel & Bootstrap.
        </div>
    </div>
</footer>

{{-- Bootstrap JS --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>
</body>
</html>
