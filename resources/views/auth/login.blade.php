<x-guest-layout>
    <div class="auth-wrapper">
        <div class="auth-card">

            {{-- Sisi kiri: hero --}}
            <div class="auth-hero">
                <div class="auth-hero-logo">
                    <img src="{{ asset('assets/img/logo-loakin.png') }}" alt="LOAK.IN">
                </div>
                <div class="auth-hero-badge">
                    <span>Masuk ke LOAK.IN</span>
                </div>
                <h1 class="auth-hero-title">Temukan & jual barang bekas dengan mudah.</h1>
                <p class="auth-hero-text">
                    Satu akun untuk mengelola semua listingmu. Pantau barang yang dijual,
                    terima laporan, dan hubungi pembeli langsung lewat WhatsApp.
                </p>
            </div>

            {{-- Sisi kanan: form login --}}
            <div class="auth-form-side">
                <h2 class="auth-form-title">Masuk</h2>
                <p class="auth-form-subtitle">
                    Silakan masuk menggunakan email dan password akun LOAK.IN kamu.
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-3" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email"
                               class="auth-input @error('email') is-invalid @enderror"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input id="password"
                               class="auth-input @error('password') is-invalid @enderror"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if (Route::has('password.request'))
                            <div class="mt-1">
                                <a class="auth-forgot" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Remember me --}}
                    <div class="mb-4 d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me" style="margin-top:0;">
                        <label class="form-check-label auth-remember" for="remember_me">
                            Ingat saya
                        </label>
                    </div>

                    {{-- Tombol + teks kecil --}}
                    <div class="auth-actions d-flex align-items-center justify-content-between">
                        <button type="submit" class="auth-submit-btn">
                            Masuk
                        </button>

                        @if (Route::has('register'))
                            <div class="auth-bottom-text">
                                Belum punya akun?
                                <a href="{{ route('register') }}">Daftar</a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
