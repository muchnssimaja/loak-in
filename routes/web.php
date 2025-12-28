<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerProfileController;
use App\Models\Listing;

// ==========================
//  HOME / BERANDA
// ==========================
Route::get('/', function () {
    // Listing terbaru (untuk section "Listing Terbaru")
    $latestListings = Listing::latest()->take(8)->get();

    // 2 listing paling mahal yang masih aktif untuk hero
    $highlightListings = Listing::where('status', 'aktif')
        ->orderByDesc('price')
        ->take(2)
        ->get();

    return view('home', [
        'latestListings'    => $latestListings,
        'highlightListings' => $highlightListings,
    ]);
})->name('home');

// ==========================
//  LISTING PUBLIK
// ==========================

// Halaman list semua listing (publik)
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// ==========================
//  AREA USER LOGIN & VERIF
// ==========================
Route::middleware(['auth'])->group(function () {

    // FORM JUAL BARANG (HARUS sebelum listings/{listing})
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');

    // Simpan listing baru
    Route::post('/listings', [ListingController::class, 'store'])
        ->name('listings.store')
        ->middleware('throttle:15,1');

    // Edit & update listing milik sendiri
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');

    // Hapus listing
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');

    // Dashboard penjual (PAKAI sellerIndex, bukan myListings)
    Route::get('/my-listings', [ListingController::class, 'sellerIndex'])
        ->name('seller.listings.index');

    // Tandai listing sebagai terjual
    Route::patch('/listings/{listing}/mark-sold', [ListingController::class, 'markSold'])
        ->name('listings.markSold');

    // Edit profil sendiri
    Route::get('/profile', [SellerProfileController::class, 'edit'])->name('seller.profile.edit');
    Route::put('/profile', [SellerProfileController::class, 'update'])->name('seller.profile.update');
});

// Profil publik penjual (bisa diakses siapa saja)
Route::get('/seller/{user}', [SellerProfileController::class, 'show'])
    ->name('seller.profile.show');

// LAPORAN LISTING (boleh dilaporkan oleh siapapun)
Route::post('/listings/{listing}/report', [ReportController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('listings.report');

// ==========================
//  DETAIL LISTING (PUBLIK)
// ==========================
// Taruh PALING BELAKANG supaya tidak menelan /create dan /edit
Route::get('/listings/{listing}', [ListingController::class, 'show'])
    ->name('listings.show');

// ==========================
//  AREA ADMIN
// ==========================
Route::middleware(['auth', 'verified', 'can:admin'])->group(function () {
    // /admin -> redirect ke daftar listing admin
    Route::get('/admin', function () {
        return redirect()->route('admin.listings.index');
    })->name('admin.home');

    // Halaman admin: semua listing + statistik + filter
    Route::get('/admin/listings', function (\Illuminate\Http\Request $request) {
        $filter = $request->query('filter'); // null | aktif | terjual | laporan

        // Query dasar, termasuk relasi user dan jumlah laporan
        $query = \App\Models\Listing::with('user')
            ->withCount('reports')
            ->latest();

        // Terapkan filter jika ada
        if ($filter === 'aktif') {
            $query->where('status', 'aktif');
        } elseif ($filter === 'terjual') {
            $query->where('status', 'terjual');
        } elseif ($filter === 'laporan') {
            $query->whereHas('reports');
        }

        $listings = $query->paginate(20);

        // Statistik untuk kartu di atas tabel
        $stats = [
            'total'   => \App\Models\Listing::count(),
            'aktif'   => \App\Models\Listing::where('status', 'aktif')->count(),
            'terjual' => \App\Models\Listing::where('status', 'terjual')->count(),
            'laporan' => \App\Models\Listing::whereHas('reports')->count(),
        ];

        return view('admin.listings.index', compact('listings', 'stats', 'filter'));
    })->name('admin.listings.index');

    // Halaman admin: semua laporan
    Route::get('/admin/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/{report}', [\App\Http\Controllers\ReportController::class, 'show'])->name('admin.reports.show');
    Route::patch('/admin/reports/{report}', [\App\Http\Controllers\ReportController::class, 'updateStatus'])->name('admin.reports.updateStatus');
});

// ==========================
//  DASHBOARD BREEZE -> HOME
// ==========================
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// ==========================
//  AUTH ROUTES (BREEZE)
// ==========================
require __DIR__.'/auth.php';
