<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; // Tambahkan ini
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user(); // ambil user yang login
        return view('profile.show', compact('user')); // kirim ke view
    }

    public function editProfile(): View
    {
        $user = auth()->user(); // ambil user yang login
        // Ubah view ke editprofile.blade.php
        return view('profile.edit', compact('user')); 
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request): RedirectResponse // Ubah tipe kembalian
    {
        $user = auth()->user();

        // Validasi input
     $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
    'password' => 'nullable|string|min:8|confirmed',
    'phone' => 'nullable|string|max:15',
    'birth_date' => 'nullable|date',
    'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
]);
$user->name = $validated['name']; // Anda belum menggunakan $validated untuk email/password!
        // 1. Tangani File Upload (Foto Profil)
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto baru di folder 'profile-photos'
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        // 2. Update field data (name, phone, birth_date)
        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? null;
        $user->birth_date = $validated['birth_date'] ?? null;
        
        $user->save(); // Simpan semua perubahan

        // Redirect ke halaman profile dengan pesan sukses
        return redirect()->route('profile.show')->with('success', 'Profile berhasil diperbarui, termasuk foto profil.');
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
  
    /**
     * Store a newly created address for the authenticated user.
     */
   // app\Http\Controllers\ProfileController.php

public function storeAddress(Request $request)
{
    // Lakukan validasi data (pastikan semua field yang Anda pakai ada di sini!)
    $validatedData = $request->validate([
        'label' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'address_line_1' => 'nullable|string|max:255', // Asumsi ada kolom ini
        'is_default' => 'nullable|boolean',
        // tambahkan field alamat lainnya (street, province, dll.)
    ]);

    $user = auth()->user();

    // 1. Gabungkan data alamat menjadi string full_address
    $validatedData['full_address'] = $validatedData['city'] . ', ' . $validatedData['postal_code'];
    // Anda mungkin ingin menyertakan address_line_1 juga

    // 2. Tambahkan user_id secara eksplisit (walaupun relasi harusnya menangani)
    // $validatedData['user_id'] = $user->id; // Tidak perlu jika menggunakan relasi create()

    // 3. Set semua alamat lama menjadi non-default jika ini adalah default
    if (isset($validatedData['is_default']) && $validatedData['is_default']) {
        $user->addresses()->update(['is_default' => false]);
    }
    
    // 4. Create address
    $user->addresses()->create($validatedData); // <-- Baris 113 sekarang akan memiliki full_address

    return redirect()->back()->with('success', 'Alamat baru berhasil ditambahkan.');
}
    }
    
   

