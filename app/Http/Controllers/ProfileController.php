<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
   public function show()
{
    $user = auth()->user(); // ambil user yang login
    return view('profile.show', compact('user')); // kirim ke view
}

    public function editProfile()
{
    $user = auth()->user(); // ambil user yang login
    return view('profile.edit', compact('user')); // kirim variabel $user ke view
}

    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    /**
     * Update the user's profile information.
     */
   public function updateProfile(Request $request)
{
    $user = auth()->user();

    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        // 'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        // Tambahkan field lain jika ada, misal 'password', 'avatar', dll
    ]);

    // Update user
    $user->update($validated);

    // Redirect ke halaman profile dengan pesan sukses
    return redirect()->route('profile.show')->with('success', 'Profile berhasil diperbarui.');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
