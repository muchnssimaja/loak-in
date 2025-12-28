<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Simpan laporan dari pengguna (frontend)
     */
    public function store(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'reason'  => ['required', 'string', 'max:100'],
            'details' => ['nullable', 'string', 'max:2000'],
        ]);

        Report::create([
            'listing_id' => $listing->id,
            'user_id'    => auth()->id(),
            'reason'     => $data['reason'],
            'details'    => $data['details'] ?? null,
            'status'     => 'baru',
        ]);

        return back()->with('success', 'Terima kasih, laporan kamu sudah terkirim ke admin.');
    }

    /**
     * Halaman admin: daftar semua laporan.
     */
    public function index()
    {
        $statusFilter  = request('status');   // baru / diproses / selesai / null
        $listingFilter = request('listing');  // filter berdasarkan listing_id (opsional)

        $baseQuery = Report::with(['listing', 'user'])->latest();

        if (in_array($statusFilter, ['baru', 'diproses', 'selesai'])) {
            $baseQuery->where('status', $statusFilter);
        }

        if ($listingFilter) {
            $baseQuery->where('listing_id', $listingFilter);
        }

        $reports = $baseQuery->paginate(20)->withQueryString();

        // Statistik global
        $stats = [
            'total'   => Report::count(),
            'baru'    => Report::where('status', 'baru')->count(),
            'diproses'=> Report::where('status', 'diproses')->count(),
            'selesai' => Report::where('status', 'selesai')->count(),
        ];

        return view('admin.reports.index', [
            'reports'        => $reports,
            'stats'          => $stats,
            'statusFilter'   => $statusFilter,
            'listingFilter'  => $listingFilter,
        ]);
    }

    /**
     * Halaman admin: detail satu laporan.
     */
    public function show(Report $report)
    {
        $report->load(['listing', 'user']);

        return view('admin.reports.show', [
            'report' => $report,
        ]);
    }

    /**
     * Admin ubah status laporan.
     */
    public function updateStatus(Request $request, Report $report)
    {
        $data = $request->validate([
            'status' => ['required', 'in:baru,diproses,selesai'],
        ]);

        $report->status = $data['status'];
        $report->save();

        return back()->with('success', 'Status laporan diperbarui.');
    }
}
