<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyJournal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_public' => 'boolean',
        'feedback_at' => 'datetime',
        'content' => 'encrypted', // Sesuai fitur keamanan sebelumnya
        // 'teacher_feedback' lama kita abaikan/tidak dipakai lagi
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Baru ke Tabel Feedback
    public function feedbacks()
    {
        return $this->hasMany(JournalFeedback::class);
    }
}
