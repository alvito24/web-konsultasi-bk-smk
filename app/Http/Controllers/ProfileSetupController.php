<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan Model User di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileSetupController extends Controller
{
    public function create()
    {
        return view('auth.profile-setup', ['user' => Auth::user()]);
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi
        $rules = [
            'phone' => 'required|string|max:15',
            'avatar' => 'required|image|max:5120', // Max 5MB
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        if ($user->role === 'siswa') {
            $rules['interests'] = 'required|string';
            $rules['career_goals'] = 'required|string';
        }

        $request->validate($rules);

        // 1. Upload Foto
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada (optional, good practice)
            // if ($user->avatar) Storage::disk('public')->delete($user->avatar);

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 2. Update Data
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);

        if ($user->role === 'siswa') {
            $user->interests = $request->interests;
            $user->career_goals = $request->career_goals;
        }

        // 3. Tandai Profil Selesai
        $user->is_profile_complete = true;

        // Simpan Perubahan
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil dilengkapi! Selamat datang.');
    }
}
