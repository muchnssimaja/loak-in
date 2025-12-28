@extends('layouts.app')
@section('title','Edit Profil')

@section('content')
<div class="loakin-page-title mb-3">
  <div class="dot"></div>
  <h2 class="h5 mb-0">Edit Profil</h2>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
  <div class="alert alert-danger small">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="row g-4">
  <div class="col-md-4">
    <div class="card-soft p-3 text-center">
      <h6>Foto Profil</h6>
      <div class="mb-3">
        @if($user->avatar_path)
          <img src="{{ asset('storage/'.$user->avatar_path) }}"
               alt="{{ $user->name }}"
               class="rounded-circle mb-2"
               width="96" height="96"
               style="object-fit: cover;">
        @else
          <div class="rounded-circle bg-skeleton mb-2"
               style="width:96px;height:96px;"></div>
        @endif
      </div>
      <div class="small text-muted">
        Kamu bisa mengganti foto saat menyimpan profil.
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card-soft p-3">
      <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label" for="name">Nama</label>
          <input id="name" type="text" name="name"
                 class="form-control" required
                 value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
          <label class="form-label" for="location">Lokasi</label>
          <input id="location" type="text" name="location"
                 class="form-control"
                 placeholder="Contoh: Medan"
                 value="{{ old('location', $user->location) }}">
        </div>

        <div class="mb-3">
          <label class="form-label" for="whatsapp">Nomor WhatsApp</label>
          <input id="whatsapp" type="text" name="whatsapp"
                 class="form-control"
                 placeholder="Contoh: 62812xxxxxxx"
                 value="{{ old('whatsapp', $user->whatsapp) }}">
          <div class="form-text">
            Nomor ini akan ditampilkan di profil publik sebagai kontak penjual.
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="bio">Tentang kamu</label>
          <textarea id="bio" name="bio" rows="3"
                    class="form-control"
                    placeholder="Ceritakan sedikit tentang dirimu atau jenis barang yang sering kamu jual.">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label" for="avatar">Foto profil</label>
          <input id="avatar" type="file" name="avatar"
                 class="form-control" accept="image/*">
          <div class="form-text">
            Maksimal 2 MB, format: JPG, PNG, WEBP.
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <button class="btn btn-brand">
            Simpan Profil
          </button>

          <a href="{{ route('seller.profile.show', $user) }}" class="small text-decoration-none">
            Lihat profil publik &raquo;
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
