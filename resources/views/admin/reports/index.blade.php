@extends('layouts.app')
@section('title','Admin • Laporan Listing')

@section('content')
<div class="loakin-page-title mb-3">
    <div class="dot"></div>
    <h2 class="h5 mb-0">Admin • Laporan Listing</h2>
</div>

@php
    use App\Models\Report;

    if (!isset($stats)) {
        $stats = [
            'total'   => Report::count(),
            'baru'    => Report::where('status','baru')->count(),
            'diproses'=> Report::where('status','diproses')->count(),
            'selesai' => Report::where('status','selesai')->count(),
        ];
    }

    $statusActive = $statusFilter ?? request('status');
@endphp

{{-- STAT KARTU --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-soft p-3 h-100">
            <div class="text-muted small">Total Laporan</div>
            <div class="h4 mb-1">{{ $stats['total'] }}</div>
            <div class="small text-muted">Semua laporan yang pernah dibuat</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-soft p-3 h-100">
            <div class="text-muted small">Baru</div>
            <div class="h4 mb-1 text-danger">{{ $stats['baru'] }}</div>
            <div class="small text-muted">Perlu diperiksa</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-soft p-3 h-100">
            <div class="text-muted small">Diproses</div>
            <div class="h4 mb-1 text-warning">{{ $stats['diproses'] }}</div>
            <div class="small text-muted">Sedang ditindaklanjuti</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-soft p-3 h-100">
            <div class="text-muted small">Selesai</div>
            <div class="h4 mb-1 text-success">{{ $stats['selesai'] }}</div>
            <div class="small text-muted">Sudah diberikan keputusan</div>
        </div>
    </div>
</div>

{{-- FILTER STATUS --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div class="btn-group btn-group-sm" role="group" aria-label="Filter status laporan">
        <a href="{{ route('admin.reports.index') }}"
           class="btn btn-sm {{ $statusActive === null ? 'btn-brand' : 'btn-outline-secondary' }}">
            Semua
        </a>
        <a href="{{ route('admin.reports.index', ['status' => 'baru']) }}"
           class="btn btn-sm {{ $statusActive === 'baru' ? 'btn-brand' : 'btn-outline-secondary' }}">
            Baru
        </a>
        <a href="{{ route('admin.reports.index', ['status' => 'diproses']) }}"
           class="btn btn-sm {{ $statusActive === 'diproses' ? 'btn-brand' : 'btn-outline-secondary' }}">
            Diproses
        </a>
        <a href="{{ route('admin.reports.index', ['status' => 'selesai']) }}"
           class="btn btn-sm {{ $statusActive === 'selesai' ? 'btn-brand' : 'btn-outline-secondary' }}">
            Selesai
        </a>
    </div>

    <div class="small text-muted">
        {{ $reports->total() }} laporan • halaman {{ $reports->currentPage() }} dari {{ $reports->lastPage() }}
    </div>
</div>

{{-- TABEL LAPORAN --}}
@if($reports->isEmpty())
    <div class="alert alert-info">
        Belum ada laporan untuk status ini.
    </div>
@else
    <div class="card-soft p-0">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Listing</th>
                    <th>Penjual</th>
                    <th>Pelapor</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th class="text-end">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $r)
                    @php
                        $listing = $r->listing ?? null;
                        $seller  = $listing?->user ?? null;
                    @endphp
                    <tr>
                        {{-- NOMOR URUT, bukan ID report --}}
                        <td>{{ $reports->firstItem() + $loop->index }}</td>

                        <td>
                            @if($listing)
                                <a href="{{ route('listings.show',$listing) }}"
                                   class="text-decoration-none">
                                    {{ \Illuminate\Support\Str::limit($listing->title, 45) }}
                                </a>
                                <div class="small text-muted">
                                    Listing ID: {{ $listing->id }}
                                </div>
                            @else
                                <span class="text-muted small">Listing tidak ditemukan</span>
                            @endif
                        </td>
                        <td>
                            @if($seller)
                                <div class="small fw-semibold">{{ $seller->name }}</div>
                                <div class="small text-muted">{{ $seller->email }}</div>
                            @else
                                <span class="small text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="small fw-semibold">
                                {{ $r->reporter_name ?? 'Pengguna' }}
                            </div>
                            <div class="small text-muted">
                                {{ $r->reporter_email ?? $r->ip_address ?? '' }}
                            </div>
                        </td>
                        <td>
                            <div class="small fw-semibold">
                                {{ ucfirst($r->reason ?? '-') }}
                            </div>
                            @if($r->message)
                                <div class="small text-muted">
                                    {{ \Illuminate\Support\Str::limit($r->message, 60) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @switch($r->status)
                                @case('baru')
                                    <span class="badge bg-danger">Baru</span>
                                    @break
                                @case('diproses')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                    @break
                                @case('selesai')
                                    <span class="badge bg-success">Selesai</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $r->status }}</span>
                            @endswitch
                        </td>
                        <td class="small">
                            {{ optional($r->created_at)->format('d-m-Y H:i') }}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.reports.show',$r) }}"
                               class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-3 border-top">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    </div>
@endif
@endsection
