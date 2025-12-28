<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function __construct()
    {
        // Tamu boleh lihat index + show saja
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Halaman semua listing (public) + search + filter kategori.
     */
    public function index(Request $request)
    {
        $query = Listing::query()
            ->where('status', 'aktif'); // hanya tampilkan yang aktif di halaman publik

        // Pencarian teks
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // Filter kategori (pakai slug)
        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $listings = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Untuk dropdown/filter kategori di halaman index
        $categories = Category::orderBy('name')->get();

        return view('listings.index', [
            'listings'   => $listings,
            'categories' => $categories,
        ]);
    }

    /**
     * Detail 1 listing.
     */
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing,
        ]);
    }

    /**
     * Form jual barang (create).
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::orderBy('name')->get();

        return view('listings.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Simpan listing baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'location'    => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            // kategori disimpan sebagai slug
            'category'    => ['required', 'string', 'max:100'],
            'image'       => ['nullable', 'image', 'max:2048'], // 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('listings', 'public');
        }

        $listing = new Listing();
        $listing->user_id     = Auth::id();
        $listing->title       = $validated['title'];
        $listing->price       = $validated['price'];
        $listing->location    = $validated['location'];
        $listing->description = $validated['description'];
        $listing->category    = $validated['category']; // slug kategori
        $listing->status      = 'aktif';
        if ($imagePath) {
            $listing->image_path = $imagePath;
        }
        $listing->save();

        return redirect()
            ->route('seller.listings.index')
            ->with('success', 'Listing berhasil dibuat.');
    }

    /**
     * Form edit listing.
     */
    public function edit(Listing $listing)
    {
        $this->ensureCanManage($listing);

        $categories = Category::orderBy('name')->get();

        return view('listings.edit', [
            'listing'    => $listing,
            'categories' => $categories,
        ]);
    }

    /**
     * Update listing.
     */
    public function update(Request $request, Listing $listing)
    {
        $this->ensureCanManage($listing);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'location'    => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category'    => ['required', 'string', 'max:100'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama kalau ada
            if ($listing->image_path && Storage::disk('public')->exists($listing->image_path)) {
                Storage::disk('public')->delete($listing->image_path);
            }
            $listing->image_path = $request->file('image')->store('listings', 'public');
        }

        $listing->title       = $validated['title'];
        $listing->price       = $validated['price'];
        $listing->location    = $validated['location'];
        $listing->description = $validated['description'];
        $listing->category    = $validated['category'];
        $listing->save();

        return redirect()
            ->route('seller.listings.index')
            ->with('success', 'Listing berhasil diperbarui.');
    }

    /**
     * Hapus listing.
     */
    public function destroy(Listing $listing)
    {
        $this->ensureCanManage($listing);

        if ($listing->image_path && Storage::disk('public')->exists($listing->image_path)) {
            Storage::disk('public')->delete($listing->image_path);
        }

        $listing->delete();

        // Kalau admin hapus dari halaman admin, arahkan balik ke admin list
        if (Auth::user()->is_admin ?? false) {
            return redirect()
                ->route('admin.listings.index')
                ->with('success', 'Listing berhasil dihapus.');
        }

        // kalau penjual biasa
        return redirect()
            ->route('seller.listings.index')
            ->with('success', 'Listing berhasil dihapus.');
    }

    /**
     * Dashboard penjual: /my-listings
     */
    public function sellerIndex(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->get('status'); // null / aktif / terjual

        $query = Listing::where('user_id', $user->id);

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $listings = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total'   => Listing::where('user_id', $user->id)->count(),
            'aktif'   => Listing::where('user_id', $user->id)->where('status', 'aktif')->count(),
            'terjual' => Listing::where('user_id', $user->id)->where('status', 'terjual')->count(),
        ];

        return view('seller.listings.index', [
            'listings'     => $listings,
            'stats'        => $stats,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Tandai listing sebagai TERJUAL.
     */
    public function markSold(Listing $listing)
    {
        $this->ensureCanManage($listing);

        $listing->status = 'terjual';
        $listing->save();

        return redirect()
            ->route('seller.listings.index')
            ->with('success', 'Listing ditandai sebagai terjual.');
    }

    /**
     * Helper: hanya pemilik atau admin yang boleh ubah/hapus.
     */
    protected function ensureCanManage(Listing $listing): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        // Admin boleh semua, kalau bukan admin harus pemilik
        if (!($user->is_admin ?? false) && $listing->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke listing ini.');
        }
    }
}
