<x-guest-layout>
    <div class="auth-wrapper">
        <div class="auth-card">

            {{-- Sisi kiri: hero --}}
            <div class="auth-hero">
                <div class="auth-hero-logo">
                    <img src="{{ asset('assets/img/logo-loakin.png') }}" alt="LOAK.IN">
                </div>
                <div class="auth-hero-badge">
                    <span>Daftar akun baru</span>
                </div>
                <h1 class="auth-hero-title">Mulai jual & beli barang bekas hari ini.</h1>
                <p class="auth-hero-text">
                    Buat akun gratis, pasang foto barang, tulis deskripsi, dan tunggu pembeli menghubungimu.
                    Tidak ada biaya komisi, cocok untuk pelajar dan UMKM.
                </p>
            </div>

            {{-- Sisi kanan: form register --}}
            <div class="auth-form-side">
                <h2 class="auth-form-title">Daftar</h2>
                <p class="auth-form-subtitle">
                    Isi data berikut untuk membuat akun LOAK.IN.
                </p>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label">Nama lengkap</label>
                        <input id="name"
                               class="auth-input @error('name') is-invalid @enderror"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email"
                               class="auth-input @error('email') is-invalid @enderror"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input id="password"
                               class="auth-input @error('password') is-invalid @enderror"
                               type="password"
                               name="password"
                               required
                               autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-4">
                        <label class="form-label">Konfirmasi password</label>
                        <input id="password_confirmation"
                               class="auth-input"
                               type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password">
                    </div>

                    {{-- Tombol + teks kecil --}}
                    <div class="auth-actions d-flex align-items-center justify-content-between">
                        <button type="submit" class="auth-submit-btn">
                            Buat Akun
                        </button>

                        @if (Route::has('login'))
                            <div class="auth-bottom-text">
                                Sudah punya akun?
                                <a href="{{ route('login') }}">Masuk</a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
