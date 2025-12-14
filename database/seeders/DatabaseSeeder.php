<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_profile_complete' => true, // Admin dianggap udah lengkap
        ]);

        // 2. Akun Guru BK
        User::create([
            'name' => 'Bu Citra (Guru BK)',
            'email' => 'bk@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru_bk',
            'nis_nip' => '198501012010012001',
            'phone' => '081299998888',
            'is_profile_complete' => true,
        ]);

        // 3. Akun Wali Kelas
        User::create([
            'name' => 'Pak Budi (Wali Kelas)',
            'email' => 'wali@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'nis_nip' => '199002022015021002',
            'class_name' => 'XII RPL 1',
            'phone' => '081277776666',
            'is_profile_complete' => true,
        ]);

        // 4. Akun Siswa (Data Dummy)
        User::create([
            'name' => 'Andi Siswa',
            'email' => 'siswa@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nis_nip' => '12345678',
            'class_name' => 'XII RPL 1',
            'phone' => '085600001111',
            // Hapus hobbies, cukup interests dan career_goals
            'interests' => 'Coding, Basket',
            'career_goals' => 'Programmer',
            'is_profile_complete' => true,
        ]);
    }
}
