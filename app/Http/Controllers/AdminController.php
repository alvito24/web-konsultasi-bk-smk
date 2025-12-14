<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // --- MANAJEMEN SISWA ---

    public function indexSiswa()
    {
        $students = User::where('role', 'siswa')->latest()->get();
        return view('admin.students.index', compact('students'));
    }

    public function createSiswa()
    {
        return view('admin.students.create');
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nis_nip' => 'required|string|unique:users',
            'class_name' => 'required|string',
            'gender' => 'required|in:L,P', // Validasi Gender
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('sekolah123'),
            'role' => 'siswa',
            'nis_nip' => $request->nis_nip,
            'class_name' => $request->class_name,
            'gender' => $request->gender, // Simpan Gender
            'is_profile_complete' => false,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    // NEW: Edit Siswa
    public function editSiswa($id)
    {
        $student = User::where('role', 'siswa')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    // NEW: Update Siswa
    public function updateSiswa(Request $request, $id)
    {
        $student = User::where('role', 'siswa')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($student->id)],
            'nis_nip' => ['required', 'string', Rule::unique('users')->ignore($student->id)],
            'class_name' => 'required|string',
            'gender' => 'required|in:L,P', // Validasi Gender
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'nis_nip' => $request->nis_nip,
            'class_name' => $request->class_name,
            'gender' => $request->gender, // Update Gender
        ]);

        if ($request->reset_password) {
            $student->update([
                'password' => Hash::make('sekolah123'),
                'is_profile_complete' => false
            ]);
            return redirect()->route('admin.students.index')->with('success', 'Siswa diupdate & Password direset.');
        }

        return redirect()->route('admin.students.index')->with('success', 'Data Siswa berhasil diperbarui.');
    }

    // NEW: Delete Siswa
    public function destroySiswa($id)
    {
        $student = User::where('role', 'siswa')->findOrFail($id);
        $student->delete();
        return redirect()->back()->with('success', 'Data Siswa berhasil dihapus.');
    }


    // --- MANAJEMEN GURU ---

    public function indexGuru()
    {
        $teachers = User::whereIn('role', ['guru_bk', 'wali_kelas'])->latest()->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function createGuru()
    {
        return view('admin.teachers.create');
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nis_nip' => 'required|string|unique:users',
            'role' => 'required|in:guru_bk,wali_kelas',
            'class_name' => 'nullable|string', // <--- TAMBAH VALIDASI INI
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('guru123'),
            'role' => $request->role,
            'nis_nip' => $request->nis_nip,
            'class_name' => $request->class_name, // <--- TAMBAH SIMPAN INI
            'is_profile_complete' => false,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil ditambahkan.');
    }

    // NEW: Edit Guru
    public function editGuru($id)
    {
        $teacher = User::whereIn('role', ['guru_bk', 'wali_kelas'])->findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    // NEW: Update Guru
    public function updateGuru(Request $request, $id)
    {
        $teacher = User::whereIn('role', ['guru_bk', 'wali_kelas'])->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($teacher->id)],
            'nis_nip' => ['required', 'string', Rule::unique('users')->ignore($teacher->id)],
            'role' => 'required|in:guru_bk,wali_kelas',
            'class_name' => 'nullable|string', // <--- TAMBAH VALIDASI INI
        ]);

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
            'nis_nip' => $request->nis_nip,
            'role' => $request->role,
            'class_name' => $request->class_name, // <--- TAMBAH UPDATE INI
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    // NEW: Delete Guru
    public function destroyGuru($id)
    {
        $teacher = User::whereIn('role', ['guru_bk', 'wali_kelas'])->findOrFail($id);
        $teacher->delete();
        return redirect()->back()->with('success', 'Data Guru berhasil dihapus.');
    }
}
