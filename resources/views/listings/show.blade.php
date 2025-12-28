@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', $listing->title)

@section('content')
<div class="row g-4">
  {{-- Kolom kiri: detail listing + status --}}
  <div class="col-lg-7">
    <div class="card shadow-sm">
      @if($listing->image_path)
        <img src="{{ asset('storage/'.$listing->image_path) }}" class="card-img-top" alt="{{ $listing->title }}">
      @else
        <div class="ratio ratio-4x3 bg-skeleton rounded-top"></div>
      @endif

      <div class="card-body">
        {{-- Judul + badge status --}}
        <h3 class="h4 d-flex align-items-center gap-2">
          {{ $listing->title }}
          @if($listing->status === 'terjual')
            <span class="badge bg-secondary">Terjual</span>
          @endif
        </h3>

        <div class="fs-5 fw-bold">Rp{{ number_format($listing->price,0,',','.') }}</div>
        <div class="text-muted">{{ $listing->location }}</div>

        @if($listing->description)
          <p class="mt-3">{!! nl2br(e($listing->description)) !!}</p>
        @endif

        {{-- Tombol aksi untuk pemilik / admin --}}
        @can('update', $listing)
          <div class="d-flex flex-wrap gap-2 mt-3 mb-3">
            <a href="{{ route('listings.edit',$listing) }}" class="btn btn-outline-secondary">
              Edit
            </a>

            @if($listing->status !== 'terjual')
              <form method="POST" action="{{ route('listings.markSold',$listing) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-outline-success" onclick="return confirm('Tandai sebagai terjual?')">
                  Tandai Terjual
                </button>
              </form>
            @endif

            <form method="POST" action="{{ route('listings.destroy',$listing) }}">
              @csrf
              @method('DELETE')
              <button class="btn btn-outline-danger" onclick="return confirm('Hapus listing ini?')">
                Hapus
              </button>
            </form>
          </div>
        @endcan

        {{-- Form laporan listing --}}
        <div class="border-top pt-3 mt-3">
          <div class="small text-muted mb-1">
            Melihat sesuatu yang mencurigakan pada listing ini?
          </div>

          <form method="POST" action="{{ route('listings.report', $listing) }}" class="row g-2">
            @csrf
            <div class="col-12 col-md-6">
              <select name="reason" class="form-select form-select-sm" required>
                <option value="">Pilih alasan pelaporan...</option>
                <option value="harga tidak wajar">Harga tidak wajar / penipuan</option>
                <option value="konten tidak pantas">Konten tidak pantas</option>
                <option value="barang tidak sesuai kategori">Barang tidak sesuai kategori</option>
                <option value="duplikat / spam">Duplikat / spam</option>
                <option value="lainnya">Lainnya</option>
              </select>
            </div>
            <div class="col-12 col-md-6">
              <input type="text"
                     name="details"
                     class="form-control form-control-sm"
                     placeholder="Keterangan tambahan (opsional)">
            </div>
            <div class="col-12 mt-1">
              <button class="btn btn-outline-danger btn-sm">
                Laporkan listing ini
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  {{-- Kolom kanan: info penjual + kategori --}}
  <div class="col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5>Kontak Penjual</h5>
        <div class="mb-2">
  {{ $listing->seller_name ?? 'Penjual' }}
</div>

@if($listing->user)
  <div class="small mb-2">
    <a href="{{ route('seller.profile.show', $listing->user) }}"
       class="text-decoration-none">
      Lihat profil penjual &raquo;
    </a>
  </div>
@endif

        @if($listing->seller_contact)
          @if($listing->status === 'terjual')
            {{-- Barang sudah terjual: WA dibatasi --}}
            <button class="btn btn-secondary w-100 mb-2" disabled>
              Barang ini sudah terjual
            </button>
            <div class="small text-muted">
              Kontak penjual disembunyikan karena status listing sudah <strong>Terjual</strong>.
            </div>
          @else
            {{-- Barang masih aktif: WA boleh diklik --}}
            <a class="btn btn-brand w-100 mb-2"
               href="https://wa.me/{{ preg_replace('/\D/','',$listing->seller_contact) }}"
               target="_blank">
              Hubungi via WhatsApp
            </a>
            <div class="small text-muted">Kontak: {{ $listing->seller_contact }}</div>
          @endif
        @else
          <div class="text-muted">Kontak tidak tersedia</div>
        @endif

        <div class="mt-3">
          <strong>Kategori:</strong>
          @forelse($listing->categories as $c)
            <span class="badge badge-category">{{ $c->name }}</span>
          @empty
            <span class="text-muted">-</span>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
