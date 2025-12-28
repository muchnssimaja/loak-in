@extends('layouts.app')

@section('title', 'Edit Listing - LOAK.IN')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Edit Listing</h5>
                    <p class="text-muted mb-4">
                        Perbarui informasi barang bekas yang kamu jual di LOAK.IN.
                    </p>

                    <form action="{{ route('listings.update', $listing) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input
                                type="text"
                                name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $listing->title) }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input
                                type="number"
                                name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $listing->price) }}"
                                min="0"
                                required
                            >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input
                                type="text"
                                name="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location', $listing->location) }}"
                                required
                            >
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori (dropdown 1 kategori) --}}
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select
                                name="category"
                                class="form-select @error('category') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Pilih kategori --</option>
                                @foreach ($categories as $cat)
                                    <option
                                        value="{{ $cat->slug }}"
                                        @selected(old('category', $listing->category) === $cat->slug)
                                    >
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                required
                            >{{ old('description', $listing->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Foto barang --}}
                        <div class="mb-4">
                            <label class="form-label">Foto barang</label>

                            @if ($listing->image_path)
                                <div class="mb-2">
                                    <img
                                        src="{{ asset('storage/' . $listing->image_path) }}"
                                        alt="{{ $listing->title }}"
                                        class="img-fluid rounded"
                                        style="max-height: 200px; object-fit: contain;"
                                    >
                                </div>
                            @endif

                            <input
                                type="file"
                                name="image"
                                class="form-control @error('image') is-invalid @enderror"
                            >
                            <div class="form-text">
                                Biarkan kosong jika tidak ingin mengganti foto. Maksimal 2 MB, format JPG/PNG/WEBP.
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('seller.listings.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
