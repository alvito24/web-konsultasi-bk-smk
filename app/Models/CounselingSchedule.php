<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
        'is_booked' => 'boolean',
    ];

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    // RELASI PINTAR: Mencari Sesi Konseling yang cocok dengan jadwal ini
    public function session()
    {
        if ($this->date === null) {
            return $this->hasOne(CounselingSession::class, 'counselor_id', 'counselor_id')->whereRaw('1 = 0');
        }

        // AMBIL JAM MULAI SAJA (Misal "08:00 - 09:00" -> "08:00")
        // Kita trim biar aman dari spasi yang tidak sengaja
        $startTime = trim(explode('-', $this->time_slot)[0]);

        // Cari sesi yang:
        // 1. Guru sama
        // 2. Tanggal sama
        // 3. Jam mulai sama (menggunakan whereTime untuk mencocokkan jam:menit)
        return $this->hasOne(CounselingSession::class, 'counselor_id', 'counselor_id')
            ->whereDate('scheduled_at', $this->date)
            ->whereTime('scheduled_at', $startTime);
    }
}
