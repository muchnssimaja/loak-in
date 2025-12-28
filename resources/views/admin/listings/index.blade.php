@extends('layouts.app')

@section('title', 'Admin • Semua Listing')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <span class="rounded-circle" style="width:10px;height:10px;background:#22c55e;"></span>
            <h1 class="h5 mb-0">Admin • Semua Listing</h1>
        </div>
        <div class="small text-muted">
            {{ $listings->total() }} data • halaman {{ $listings->currentPage() }} dari {{ $listings->lastPage() }}
        </div>
    </div>

    {{-- STAT KARTU --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-muted mb-1">Total Listing</div>
                    <div class="fs-4 fw-semibold mb-1">
                        {{ $stats['total'] ?? $listings->total() }}
                    </div>
                    <div class="small text-muted">
                        Semua listing yang pernah dibuat.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-muted mb-1">Aktif</div>
                    <div class="fs-4 fw-semibold text-success mb-1">
                        {{ $stats['aktif'] ?? 0 }}
                    </div>
                    <div class="small text-muted">
                        Masih tampil di beranda dan bisa dibeli.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-muted mb-1">Terjual</div>
                    <div class="fs-4 fw-semibold text-secondary mb-1">
                        {{ $stats['terjual'] ?? 0 }}
                    </div>
                    <div class="small text-muted">
                        Sudah ditandai terjual oleh penjual.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-muted mb-1">Dilaporkan</div>
                    <div class="fs-4 fw-semibold text-danger mb-1">
                        {{ $stats['laporan'] ?? 0 }}
                    </div>
                    <div class="small text-muted">
                        Listing yang memiliki laporan dari pengguna.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB FILTER --}}
    @php $currentFilter = $filter ?? null; @endphp
    <div class="mb-3">
        <div class="btn-group" role="group" aria-label="Filter listing">
            <a href="{{ route('admin.listings.index') }}"
               class="btn btn-sm {{ $currentFilter === null ? 'btn-success' : 'btn-outline-secondary' }}">
                Semua
            </a>
            <a href="{{ route('admin.listings.index', ['filter' => 'aktif']) }}"
               class="btn btn-sm {{ $currentFilter === 'aktif' ? 'btn-success' : 'btn-outline-secondary' }}">
                Aktif
            </a>
            <a href="{{ route('admin.listings.index', ['filter' => 'terjual']) }}"
               class="btn btn-sm {{ $currentFilter === 'terjual' ? 'btn-success' : 'btn-outline-secondary' }}">
                Terjual
            </a>
            <a href="{{ route('admin.listings.index', ['filter' => 'laporan']) }}"
               class="btn btn-sm {{ $currentFilter === 'laporan' ? 'btn-success' : 'btn-outline-secondary' }}">
                Dilaporkan
            </a>
        </div>
    </div>

    {{-- TABEL LISTING ADMIN --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="text-center">#</th>
                            <th>Judul</th>
                            <th style="width: 150px;">Harga</th>
                            <th style="width: 190px;">Penjual</th>
                            <th style="width: 150px;">Lokasi</th>
                            <th style="width: 90px;">Status</th>
                            <th style="width: 120px;">Laporan</th>
                            <th style="width: 170px;">Dibuat</th>
                            <th style="width: 90px;" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listings as $l)
                            @php
                                $reportCount = $l->reports_count ?? ($l->reports->count() ?? 0);
                            @endphp
                            <tr>
                                {{-- NOMOR URUT --}}
                                <td class="text-center align-middle">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- JUDUL + FOTO + ID --}}
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        {{-- FOTO PRODUK: tidak terpotong --}}
                                        <div class="me-3 flex-shrink-0"
                                             style="width:56px;height:56px;border-radius:14px;overflow:hidden;background:#f3f4f6;">
                                            @if ($l->image_path)
                                                <img src="{{ asset('storage/'.$l->image_path) }}"
                                                     alt="{{ $l->title }}"
                                                     style="width:100%;height:100%;object-fit:contain;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">
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
                                            <div class="small text-muted">
                                                ID: {{ $l->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- HARGA --}}
                                <td class="align-middle fw-semibold">
                                    Rp{{ number_format($l->price, 0, ',', '.') }}
                                </td>

                                {{-- PENJUAL --}}
                                <td class="align-middle">
                                    <div class="fw-semibold small">
                                        {{ $l->user->name ?? '-' }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $l->user->email ?? '' }}
                                    </div>
                                </td>

                                {{-- LOKASI --}}
                                <td class="align-middle small text-uppercase">
                                    {{ $l->location }}
                                </td>

                                {{-- STATUS --}}
                                <td class="align-middle">
                                    @if ($l->status === 'terjual')
                                        <span class="badge bg-secondary rounded-pill px-3">Terjual</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                    @endif
                                </td>

                                {{-- LAPORAN --}}
                                <td class="align-middle">
                                    @if ($reportCount > 0)
                                        <span class="badge bg-danger rounded-pill px-3">
                                            {{ $reportCount }} laporan
                                        </span>
                                    @else
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3">
                                            Bersih
                                        </span>
                                    @endif
                                </td>

                                {{-- TANGGAL DIBUAT --}}
                                <td class="align-middle small text-muted">
                                    {{ $l->created_at->format('d-m-Y H:i') }}
                                </td>

                                {{-- AKSI (hapus) --}}
                                <td class="align-middle text-end">
                                    <form action="{{ route('listings.destroy', $l) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus listing ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger rounded-pill">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Belum ada listing yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if ($listings->hasPages())
            <div class="card-footer border-0">
                {{ $listings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
