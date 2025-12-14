<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalFeedback extends Model
{
    protected $table = 'journal_feedbacks';
    protected $guarded = ['id'];

    // Relasi ke Guru
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relasi ke Jurnal
    public function journal()
    {
        return $this->belongsTo(DailyJournal::class, 'daily_journal_id');
    }
}
