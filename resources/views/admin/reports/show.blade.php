@extends('layouts.app')
@section('title','Admin • Detail Laporan')

@section('content')
<div class="loakin-page-title mb-3">
  <div class="dot"></div>
  <h2 class="h5 mb-0">Admin • Detail Laporan #{{ $report->id }}</h2>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-3">
  {{-- Info laporan --}}
  <div class="col-md-7">
    <div class="card-soft p-3 h-100">
      <h6 class="mb-2">Informasi Laporan</h6>
      <dl class="row small mb-0">
        <dt class="col-4">ID Laporan</dt>
        <dd class="col-8">#{{ $report->id }}</dd>

        <dt class="col-4">Status</dt>
        <dd class="col-8">
          @if($report->status === 'baru')
            <span class="badge bg-danger">Baru</span>
          @elseif($report->status === 'diproses')
            <span class="badge bg-warning text-dark">Diproses</span>
          @else
            <span class="badge bg-success">Selesai</span>
          @endif
        </dd>

        <dt class="col-4">Dibuat pada</dt>
        <dd class="col-8">{{ $report->created_at?->format('d-m-Y H:i') }}</dd>

        <dt class="col-4">Pelapor</dt>
        <dd class="col-8">
          @if($report->user)
            {{ $report->user->name }} (ID: {{ $report->user->id }})
          @else
            <span class="text-muted">Tamu / tidak login</span>
          @endif
        </dd>

        <dt class="col-4">Alasan</dt>
        <dd class="col-8">{{ $report->reason }}</dd>

        <dt class="col-4">Keterangan</dt>
        <dd class="col-8">
          @if($report->details)
            {{ $report->details }}
          @else
            <span class="text-muted">-</span>
          @endif
        </dd>
      </dl>
    </div>
  </div>

  {{-- Info listing terkait + aksi --}}
  <div class="col-md-5">
    <div class="card-soft p-3 mb-3">
      <h6 class="mb-2">Listing yang dilaporkan</h6>

      @if($report->listing)
        <div class="small mb-2">
          <strong>{{ $report->listing->title }}</strong><br>
          <span class="text-muted">
            Rp{{ number_format($report->listing->price, 0, ',', '.') }} •
            {{ $report->listing->location }}
          </span>
        </div>

        <div class="mb-2">
          <a href="{{ route('listings.show', $report->listing) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            Lihat di frontend
          </a>
        </div>
      @else
        <div class="text-muted small mb-0">
          Listing sudah dihapus.
        </div>
      @endif
    </div>

    <div class="card-soft p-3">
      <h6 class="mb-2">Ubah status laporan</h6>
      <form method="POST" action="{{ route('admin.reports.updateStatus', $report) }}">
        @csrf
        @method('PATCH')
        <div class="mb-2">
          <select name="status" class="form-select form-select-sm">
            <option value="baru"     @selected($report->status === 'baru')>Baru</option>
            <option value="diproses" @selected($report->status === 'diproses')>Diproses</option>
            <option value="selesai"  @selected($report->status === 'selesai')>Selesai</option>
          </select>
        </div>
        <button class="btn btn-brand btn-sm">
          Simpan Status
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
