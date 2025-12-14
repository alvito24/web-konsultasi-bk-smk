<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // 1. Update Data Dasar (Breeze Default)
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 2. Logic Upload Avatar Baru
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada (optional, good practice)
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Simpan yang baru
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // 3. Logic Data Tambahan Sesuai Role
        // Kita simpan field extra yang sudah divalidasi
        $user->nis_nip = $request->nis_nip;
        $user->phone = $request->phone;

        if ($user->role === 'siswa') {
            $user->class_name = $request->class_name;
            $user->interests = $request->interests;
            $user->career_goals = $request->career_goals;
        } elseif ($user->role === 'wali_kelas') {
            $user->class_name = $request->class_name; // Wali kelas juga butuh field kelas
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
