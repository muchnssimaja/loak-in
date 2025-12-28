@extends('layouts.app')

@section('title', 'Listing Saya')

@section('content')
<div class="container py-4">

    {{-- Header + tombol jual --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Dashboard Penjual</h1>
            <p class="text-muted small mb-0">
                Kelola semua barang yang kamu jual di LOAK.IN.
            </p>
        </div>
        <a href="{{ route('listings.create') }}" class="btn btn-success rounded-pill">
            + Jual Barang
        </a>
    </div>

    {{-- STAT KARTU --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Total Listing</div>
                    <div class="h4 mb-0">
                        {{ $stats['total'] ?? $listings->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Listing Aktif</div>
                    <div class="h4 mb-0">
                        {{ $stats['aktif'] ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Sudah Terjual</div>
                    <div class="h4 mb-0">
                        {{ $stats['terjual'] ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER STATUS + TOMBOL JUAL --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        @php $status = $statusFilter ?? null; @endphp

        <div class="btn-group" role="group" aria-label="Filter status">
            <a href="{{ route('seller.listings.index') }}"
               class="btn btn-sm {{ $status === null ? 'btn-success' : 'btn-outline-secondary' }}">
                Semua
            </a>
            <a href="{{ route('seller.listings.index', ['status' => 'aktif']) }}"
               class="btn btn-sm {{ $status === 'aktif' ? 'btn-success' : 'btn-outline-secondary' }}">
                Aktif
            </a>
            <a href="{{ route('seller.listings.index', ['status' => 'terjual']) }}"
               class="btn btn-sm {{ $status === 'terjual' ? 'btn-success' : 'btn-outline-secondary' }}">
                Terjual
            </a>
        </div>
    </div>

    {{-- TABEL LISTING SAYA --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="text-center">#</th>
                            <th>Barang</th>
                            <th style="width: 140px;">Harga</th>
                            <th style="width: 140px;">Lokasi</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 160px;">Dibuat</th>
                            <th style="width: 170px;" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listings as $l)
                            <tr>
                                {{-- NOMOR URUT SELALU MULAI DARI 1 --}}
                                <td class="text-center align-middle">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- FOTO PRODUK + JUDUL + LOKASI --}}
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        {{-- WRAPPER FOTO: ukuran fixed, gambar full tanpa terpotong --}}
                                        <div class="me-3 flex-shrink-0"
                                             style="width:64px;height:64px;border-radius:14px;overflow:hidden;
                                                    background:#f3f4f6;">
                                            @if ($l->image_path)
                                                <img src="{{ asset('storage/'.$l->image_path) }}"
                                                     alt="{{ $l->title }}"
                                                     style="width:100%;height:100%;object-fit:contain;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center
                                                            text-muted small">
                                                    No image
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <div class="fw-semibold text-truncate">
                                                <a href="{{ route('listings.show', $l) }}">
                                                    {{ strtoupper($l->title) }}
                                                </a>
                                            </div>
                                            <div class="small text-muted text-uppercase">
                                                {{ $l->location }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- HARGA --}}
                                <td class="align-middle fw-semibold">
                                    Rp{{ number_format($l->price, 0, ',', '.') }}
                                </td>

                                {{-- LOKASI --}}
                                <td class="align-middle text-uppercase small">
                                    {{ $l->location }}
                                </td>

                                {{-- STATUS BADGE --}}
                                <td class="align-middle">
                                    @if ($l->status === 'terjual')
                                        <span class="badge bg-secondary rounded-pill px-3">Terjual</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                    @endif
                                </td>

                                {{-- TANGGAL BUAT --}}
                                <td class="align-middle small text-muted">
                                    {{ $l->created_at->format('d-m-Y H:i') }}
                                </td>

                                {{-- AKSI --}}
                                <td class="align-middle text-end">
                                    {{-- tombol tandai terjual --}}
                                    @if ($l->status !== 'terjual')
                                        <form action="{{ route('listings.markSold', $l) }}" method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-success rounded-pill">
                                                Terjual
                                            </button>
                                        </form>
                                    @endif

                                    {{-- edit --}}
                                    <a href="{{ route('listings.edit', $l) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill ms-1">
                                        Edit
                                    </a>

                                    {{-- hapus --}}
                                    <form action="{{ route('listings.destroy', $l) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus listing ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger rounded-pill ms-1">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Kamu belum memiliki listing. Mulai dengan klik
                                    <strong>Jual Barang</strong>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION (kalau ada) --}}
        @if ($listings->hasPages())
            <div class="card-footer border-0">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
