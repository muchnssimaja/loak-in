@extends('layouts.app')

@section('title','LOAK.IN')

@section('content')
{{-- HERO SECTION --}}
<section class="hero-section">
  <div class="row align-items-center g-4">
    <div class="col-lg-6">
      <div class="hero-highlight mb-3">
        <span class="hero-badge-dot"></span>
        Platform jual-beli barang bekas untuk semua
      </div>

      <h1 class="hero-title mb-2">
        Jual & beli barang bekas
        <br>
        dengan mudah di <span class="text-brand">LOAK.IN</span>
      </h1>

      <p class="hero-subtitle mb-3">
        Satu tempat untuk melepas barang bekas berkualitas dan menemukan barang
        hemat yang masih layak pakai. Cocok untuk pelajar, UMKM, dan siapa saja.
      </p>

      <div class="d-flex flex-wrap gap-2 mb-2">
        @auth
          <a href="{{ route('listings.create') }}" class="btn btn-brand">
            Jual Barang Sekarang
          </a>
          <a href="{{ route('seller.listings.index') }}" class="btn btn-outline-secondary">
            Listing Saya
          </a>
        @endauth

        @guest
          <a href="{{ route('register') }}" class="btn btn-brand">
            Daftar & Mulai Jual
          </a>
          <a href="{{ route('listings.index') }}" class="btn btn-outline-secondary">
            Lihat Listing Terbaru
          </a>
        @endguest
      </div>

      <div class="text-muted small">
        Tidak ada biaya komisi. Kamu langsung terhubung dengan pembeli lewat WhatsApp.
      </div>
    </div>

    {{-- Sisi kanan hero: listing highlight dinamis --}}
    <div class="col-lg-6">
      <div class="row g-3">

        @php
          $first  = $highlightListings[0] ?? null;
          $second = $highlightListings[1] ?? null;
        @endphp

        {{-- Kartu pertama --}}
        <div class="col-6">
          @if($first)
            <a href="{{ route('listings.show', $first) }}" class="text-decoration-none text-dark">
              <div class="card-soft p-2 hover-rise h-100">
                @if($first->image_path)
                  <div class="ratio ratio-4x3 loakin-card-img-wrap mb-2">
                    <img src="{{ asset('storage/'.$first->image_path) }}"
                         class="loakin-card-img"
                         alt="{{ $first->title }}">
                  </div>
                @else
                  <div class="ratio ratio-4x3 bg-skeleton rounded-3 mb-2"></div>
                @endif

                <div class="small fw-semibold mb-1">
                  {{ \Illuminate\Support\Str::limit($first->title, 40) }}
                </div>
                <div class="fw-bold">
                  Rp{{ number_format($first->price,0,',','.') }}
                </div>
                <div class="small text-muted">
                  {{ $first->location }}
                </div>
              </div>
            </a>
          @else
            <div class="card-soft p-2 h-100">
              <div class="ratio ratio-4x3 bg-skeleton rounded-3 mb-2"></div>
              <div class="small text-muted">
                Belum ada listing untuk ditampilkan di sini.
              </div>
            </div>
          @endif
        </div>

        {{-- Kartu kedua --}}
        <div class="col-6">
          @if($second)
            <a href="{{ route('listings.show', $second) }}" class="text-decoration-none text-dark">
              <div class="card-soft p-2 hover-rise h-100 mt-4">
                @if($second->image_path)
                  <div class="ratio ratio-4x3 loakin-card-img-wrap mb-2">
                    <img src="{{ asset('storage/'.$second->image_path) }}"
                         class="loakin-card-img"
                         alt="{{ $second->title }}">
                  </div>
                @else
                  <div class="ratio ratio-4x3 bg-skeleton rounded-3 mb-2"></div>
                @endif

                <div class="small fw-semibold mb-1">
                  {{ \Illuminate\Support\Str::limit($second->title, 40) }}
                </div>
                <div class="fw-bold">
                  Rp{{ number_format($second->price,0,',','.') }}
                </div>
                <div class="small text-muted">
                  {{ $second->location }}
                </div>
              </div>
            </a>
          @else
            <div class="card-soft p-2 h-100 mt-4">
              <div class="ratio ratio-4x3 bg-skeleton rounded-3 mb-2"></div>
              <div class="small text-muted">
                Tambah lagi listing untuk mengisi rekomendasi ini.
              </div>
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
</section>

{{-- CARA KERJA LOAK.IN (dipindah ke atas kategori) --}}
<section class="mt-5">
  <h2 class="section-title mb-3">Cara kerja LOAK.IN</h2>
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card-soft p-3 h-100">
        <div class="mb-2">
          <span class="step-number">1</span>
          <span class="fw-semibold">Daftar & lengkapi akun</span>
        </div>
        <div class="small text-muted">
          Buat akun dengan email aktif. Setelah login, kamu bisa langsung mengelola listing barang bekasmu.
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-soft p-3 h-100">
        <div class="mb-2">
          <span class="step-number">2</span>
          <span class="fw-semibold">Pasang iklan barang bekas</span>
        </div>
        <div class="small text-muted">
          Upload foto, tulis deskripsi, atur harga dan kategori. Pembeli bisa menemukan barangmu lewat pencarian dan filter.
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-soft p-3 h-100">
        <div class="mb-2">
          <span class="step-number">3</span>
          <span class="fw-semibold">Chat langsung dengan pembeli</span>
        </div>
        <div class="small text-muted">
          Pembeli akan menghubungi kamu langsung melalui WhatsApp. Negosiasi dan transaksi bisa dilakukan di luar platform.
        </div>
      </div>
    </div>
  </div>
</section>

{{-- JELAJAHI BERDASARKAN KATEGORI (5-3-1) --}}
<section class="mt-5">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="section-title mb-0">Jelajahi berdasarkan kategori</h2>
    <a href="{{ route('listings.index') }}" class="small text-decoration-none">
      Lihat semua listing &raquo;
    </a>
  </div>

  @php
    $row1 = [
        ['name' => 'Perabot & Rumah Tangga', 'slug' => 'perabot',         'icon' => 'perabot.svg'],
        ['name' => 'Pakaian & Aksesoris',    'slug' => 'fashion',         'icon' => 'fashion.svg'],
        ['name' => 'Hobi & Koleksi',         'slug' => 'hobi-koleksi',    'icon' => 'hobi-koleksi.svg'],
        ['name' => 'Sepeda & Aksesoris',     'slug' => 'sepeda',          'icon' => 'sepeda.svg'],
        ['name' => 'Bayi & Anak',            'slug' => 'bayi-anak',       'icon' => 'bayi-anak.svg'],
    ];

    $row2 = [
        ['name' => 'Handphone & Gadget',     'slug' => 'hp-gadget',       'icon' => 'hp-gadget.svg'],
        ['name' => 'Elektronik',             'slug' => 'elektronik',      'icon' => 'elektronik.svg'],
        ['name' => 'Laptop & Komputer',      'slug' => 'laptop-komputer', 'icon' => 'laptop-komputer.svg'],
    ];

    $row3 = [
        ['name' => 'Lainnya',                'slug' => 'lainnya',         'icon' => 'lainnya.svg'],
    ];
  @endphp

  {{-- Baris 1: 5 kategori (rapi di tengah) --}}
  <div class="row g-2 mb-2 justify-content-center">
    @foreach($row1 as $cat)
      <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ route('listings.index', ['category' => $cat['slug']]) }}"
           class="text-decoration-none text-dark">
          <div class="card-soft p-3 text-center hover-rise h-100">
            <div class="mb-2">
              <img src="{{ asset('assets/img/categories/'.$cat['icon']) }}"
                   alt="{{ $cat['name'] }}"
                   style="width:32px;height:32px;">
            </div>
            <div class="mb-1 fw-semibold" style="font-size: 0.85rem;">
              {{ $cat['name'] }}
            </div>
            <div class="small text-muted">Lihat barang</div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  {{-- Baris 2: 3 kategori (tengah) --}}
  <div class="row g-2 mb-2 justify-content-center">
    @foreach($row2 as $cat)
      <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('listings.index', ['category' => $cat['slug']]) }}"
           class="text-decoration-none text-dark">
          <div class="card-soft p-3 text-center hover-rise h-100">
            <div class="mb-2">
              <img src="{{ asset('assets/img/categories/'.$cat['icon']) }}"
                   alt="{{ $cat['name'] }}"
                   style="width:32px;height:32px;">
            </div>
            <div class="mb-1 fw-semibold" style="font-size: 0.85rem;">
              {{ $cat['name'] }}
            </div>
            <div class="small text-muted">Lihat barang</div>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  {{-- Baris 3: 1 kategori (Lainnya) --}}
  <div class="row g-2 justify-content-center">
    @foreach($row3 as $cat)
      <div class="col-10 col-md-6 col-lg-4 col-xl-3">
        <a href="{{ route('listings.index', ['category' => $cat['slug']]) }}"
           class="text-decoration-none text-dark">
          <div class="card-soft p-3 text-center hover-rise h-100">
            <div class="mb-2">
              <img src="{{ asset('assets/img/categories/'.$cat['icon']) }}"
                   alt="{{ $cat['name'] }}"
                   style="width:32px;height:32px;">
            </div>
            <div class="mb-1 fw-semibold" style="font-size: 0.85rem;">
              {{ $cat['name'] }}
            </div>
            <div class="small text-muted">Lihat barang</div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</section>

{{-- LISTING TERBARU --}}
<section class="mt-5 mb-4">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="section-title mb-0">Listing Terbaru</h2>
    <a href="{{ route('listings.index') }}" class="small text-decoration-none">
      Lihat semua &raquo;
    </a>
  </div>

  <div class="row g-3">
    @forelse($latestListings as $item)
      <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('listings.show',$item) }}" class="text-decoration-none text-dark">
          <div class="card h-100 hover-rise">

            @if($item->image_path)
              <div class="ratio ratio-4x3 loakin-card-img-wrap">
                <img src="{{ asset('storage/'.$item->image_path) }}"
                     class="loakin-card-img"
                     alt="{{ $item->title }}">
              </div>
            @else
              <div class="ratio ratio-4x3 bg-skeleton loakin-card-img-wrap"></div>
            @endif

            <div class="card-body">
              <h6 class="card-title mb-1">
                {{ \Illuminate\Support\Str::limit($item->title, 40) }}
              </h6>
              <div class="fw-bold mb-1">
                Rp{{ number_format($item->price,0,',','.') }}
              </div>
              <div class="small text-muted">{{ $item->location }}</div>

              @if($item->status === 'terjual')
                <span class="badge bg-secondary mt-1">Terjual</span>
              @endif
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info mb-0">
          Belum ada listing. <a href="{{ route('listings.create') }}">Jadilah yang pertama menjual barang di LOAK.IN.</a>
        </div>
      </div>
    @endforelse
  </div>
</section>
@endsection
