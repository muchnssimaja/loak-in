@extends('layouts.app')
@section('title','Semua Listing Barang Bekas')

@section('content')
<div class="loakin-page-title mb-3">
    <div class="dot"></div>
    <h2 class="h5 mb-0">Semua Listing Barang</h2>
</div>

{{-- FILTER & PENCARIAN --}}
<form method="GET" action="{{ route('listings.index') }}" class="card-soft p-3 mb-3">
    <div class="row g-2 align-items-end">
        {{-- Kolom pencarian --}}
        <div class="col-md-6">
            <label class="form-label small text-muted mb-1">Cari barang</label>
            <input type="text"
                   name="q"
                   class="form-control form-control-sm"
                   placeholder="Cari berdasarkan nama, deskripsi, atau lokasi..."
                   value="{{ request('q') }}">
        </div>

        {{-- Filter kategori --}}
        <div class="col-md-3">
            <label class="form-label small text-muted mb-1">Kategori</label>
            <select name="category" class="form-select form-select-sm">
                <option value="">Semua kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}"
                        {{ (request('category') === $cat->slug) ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol --}}
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-brand btn-sm flex-grow-1">
                Cari
            </button>
            <a href="{{ route('listings.index') }}" class="btn btn-outline-secondary btn-sm">
                Reset
            </a>
        </div>
    </div>

    {{-- Info kecil di bawah form --}}
    <div class="mt-2 small text-muted d-flex flex-wrap gap-2">
        @php
            $total = $listings->total();
        @endphp
        <span>Menampilkan <strong>{{ $total }}</strong> listing.</span>

        @if(request('q'))
            <span>| Kata kunci: <strong>"{{ request('q') }}"</strong></span>
        @endif

        @if(request('category'))
            @php
                $catActive = $categories->firstWhere('slug', request('category'));
            @endphp
            @if($catActive)
                <span>| Kategori: <strong>{{ $catActive->name }}</strong></span>
            @endif
        @endif
    </div>
</form>

{{-- GRID LISTING --}}
@if($listings->isEmpty())
    <div class="alert alert-info">
        Tidak ada listing yang cocok dengan pencarian atau filter saat ini.
        <a href="{{ route('listings.index') }}">Reset pencarian</a> atau
        <a href="{{ route('listings.create') }}">jual barang pertama kamu.</a>
    </div>
@else
    <div class="row g-3">
        @foreach($listings as $item)
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
                            <div class="small text-muted">
                                {{ $item->location }}
                            </div>

                            @if($item->status === 'terjual')
                                <span class="badge bg-secondary mt-1">Terjual</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $listings->appends(request()->query())->links() }}
    </div>
@endif
@endsection
