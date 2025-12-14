<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    use HasFactory;

    // Ini PENTING biar bisa Create/Update data (Mass Assignment)
    protected $guarded = ['id'];

    // Biar kolom tanggal otomatis jadi objek Carbon (bisa diformat tanggalnya)
    protected $casts = [
        'scheduled_at' => 'datetime',
        // Tambahkan ini buat enkripsi otomatis
        'problem_description' => 'encrypted',
        'counselor_notes' => 'encrypted',
        'solution' => 'encrypted',
    ];

    // Relasi ke User (Siswa)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi ke User (Guru BK)
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
