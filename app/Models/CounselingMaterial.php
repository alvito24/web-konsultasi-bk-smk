<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CounselingMaterial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Relasi ke Upvotes
    public function upvotes()
    {
        return $this->hasMany(MaterialUpvote::class);
    }

    // Helper: Cek apakah user yang sedang login sudah like materi ini?
    public function isUpvotedByAuthUser()
    {
        return $this->upvotes()->where('user_id', Auth::id())->exists();
    }
}
