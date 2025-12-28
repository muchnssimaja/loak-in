<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    /**
     * Profil publik penjual + daftar listing-nya.
     */
    public function show(User $user)
    {
        $listings = Listing::where('user_id', $user->id)
            ->latest()
            ->paginate(8);

        $stats = [
            'total'   => $listings->total(),
            'aktif'   => Listing::where('user_id', $user->id)->where('status', 'aktif')->count(),
            'terjual' => Listing::where('user_id', $user->id)->where('status', 'terjual')->count(),
        ];

        return view('seller.profile.show', [
            'seller'   => $user,
            'listings' => $listings,
            'stats'    => $stats,
        ]);
    }

    /**
     * Form edit profil sendiri (penjual).
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('seller.profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Simpan perubahan profil.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'bio'      => ['nullable', 'string', 'max:1000'],
            'avatar'   => ['nullable', 'image', 'max:2048'],
        ]);

        // Upload avatar jika ada
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $path;
        }

        $user->name     = $data['name'];
        $user->location = $data['location'] ?? null;
        $user->whatsapp = $data['whatsapp'] ?? null;
        $user->bio      = $data['bio'] ?? null;

        $user->save();

        return redirect()
            ->route('seller.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
