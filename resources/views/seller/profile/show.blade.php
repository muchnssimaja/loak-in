@extends('layouts.app')
@section('title','Profil Penjual')

@section('content')
<div class="row g-4">
  {{-- Kolom kiri: info penjual --}}
  <div class="col-lg-4">
    <div class="card-soft p-3 h-100">
      <div class="d-flex align-items-center mb-3">
        <div class="me-3">
          @if($seller->avatar_path)
            <img src="{{ asset('storage/'.$seller->avatar_path) }}"
                 alt="{{ $seller->name }}"
                 class="rounded-circle"
                 width="72" height="72"
                 style="object-fit: cover;">
          @else
            <div class="rounded-circle bg-skeleton"
                 style="width:72px;height:72px;"></div>
          @endif
        </div>
        <div>
          <h5 class="mb-0">{{ $seller->name }}</h5>
          @if($seller->location)
            <div class="small text-muted">{{ $seller->location }}</div>
          @endif
          <div class="small text-muted">
            Bergabung: {{ $seller->created_at?->format('d-m-Y') }}
          </div>
        </div>
      </div>

      <div class="mb-3">
        <div class="text-muted small mb-1">Tentang penjual</div>
        @if($seller->bio)
          <div class="small">{{ $seller->bio }}</div>
        @else
          <div class="small text-muted fst-italic">
            Penjual belum menambahkan deskripsi profil.
          </div>
        @endif
      </div>

      <div class="mb-3">
        <div class="text-muted small mb-1">Kontak WhatsApp</div>
        @if($seller->whatsapp)
          <a href="https://wa.me/{{ preg_replace('/\D/','',$seller->whatsapp) }}"
             target="_blank"
             class="btn btn-brand btn-sm w-100">
            Chat via WhatsApp
          </a>
          <div class="small text-muted mt-1">
            {{ $seller->whatsapp }}
          </div>
        @else
          <div class="small text-muted">
            Penjual belum menambahkan nomor WhatsApp di profil.
          </div>
        @endif
      </div>

      <div class="row g-2 small">
        <div class="col-4">
          <div class="card-soft p-2 text-center">
            <div class="text-muted">Total</div>
            <div class="fw-bold">{{ $stats['total'] }}</div>
          </div>
        </div>
        <div class="col-4">
          <div class="card-soft p-2 text-center">
            <div class="text-muted">Aktif</div>
            <div class="fw-bold text-success">{{ $stats['aktif'] }}</div>
          </div>
        </div>
        <div class="col-4">
          <div class="card-soft p-2 text-center">
            <div class="text-muted">Terjual</div>
            <div class="fw-bold text-secondary">{{ $stats['terjual'] }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Kolom kanan: listing milik penjual --}}
  <div class="col-lg-8">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">Listing oleh {{ $seller->name }}</h5>
      <a href="{{ route('listings.index', ['seller' => $seller->id]) }}"
         class="small text-decoration-none">
        Lihat di halaman listing &raquo;
      </a>
    </div>

    @if($listings->isEmpty())
      <div class="alert alert-info">
        Penjual ini belum memiliki listing aktif.
      </div>
    @else
      <div class="row g-3">
        @foreach($listings as $item)
          <div class="col-6 col-md-4">
            <div class="card h-100 hover-rise">
              @if($item->image_path)
                <img src="{{ asset('storage/'.$item->image_path) }}"
                     class="card-img-top"
                     alt="{{ $item->title }}">
              @else
                <div class="ratio ratio-4x3 bg-skeleton"></div>
              @endif
              <div class="card-body">
                <h6 class="card-title mb-1">
                  <a href="{{ route('listings.show',$item) }}"
                     class="text-decoration-none text-dark">
                    {{ \Illuminate\Support\Str::limit($item->title, 36) }}
                  </a>
                </h6>
                <div class="fw-bold mb-1">
                  Rp{{ number_format($item->price,0,',','.') }}
                </div>
                <div class="small text-muted">
                  {{ $item->location }}
                </div>
                @if($item->status === 'terjual')
                  <span class="badge bg-secondary mt-1">Terjual</span>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-3">
        {{ $listings->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
