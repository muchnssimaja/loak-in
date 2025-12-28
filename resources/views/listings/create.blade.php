@extends('layouts.app')
@section('title','Jual Barang')

@section('content')
<div class="loakin-page-title mb-3">
    <div class="dot"></div>
    <h2 class="h5 mb-0">Jual Barang Bekas</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-soft p-3 p-md-4 mb-3">
            <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul --}}
                <div class="mb-3">
                    <label class="form-label">Judul Barang</label>
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="Contoh: Laptop bekas untuk kuliah, Lemari pakaian 2 pintu, dll.">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number"
                           name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price') }}"
                           min="0"
                           placeholder="Contoh: 500000">
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Harga dalam Rupiah, tanpa titik. Misal: 250000 (dua ratus lima puluh ribu).
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text"
                           name="location"
                           class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location') }}"
                           placeholder="Contoh: Medan, Jakarta, dll.">
                    @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dropdown kategori --}}
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category"
                            class="form-select @error('category') is-invalid @enderror">
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>
                            Pilih kategori barang
                        </option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}"
                                {{ old('category') === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Pilih kategori yang paling sesuai. Ini akan membantu pembeli menemukan barangmu.
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi Barang</label>
                    <textarea name="description"
                              rows="5"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Tuliskan kondisi barang, kelengkapan, alasan dijual, dan info penting lain.">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-3">
                    <label class="form-label">Foto Barang (opsional)</label>
                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Upload 1 foto utama barang (maksimal 2MB). Di halaman listing, gambar akan ditampilkan utuh.
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-brand">
                        Pasang Iklan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Info samping --}}
    <div class="col-lg-4">
        <div class="card-soft p-3 p-md-4">
            <h6 class="fw-semibold mb-2">Tips memasang iklan</h6>
            <ul class="small text-muted mb-0">
                <li>Gunakan judul yang jelas dan spesifik.</li>
                <li>Sertakan kondisi barang (baru / bekas, minus, dll.).</li>
                <li>Gunakan harga yang wajar agar cepat laku.</li>
                <li>Pastikan lokasi sesuai dengan tempat COD / pengiriman.</li>
                <li>Foto yang jelas akan menarik lebih banyak pembeli.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
