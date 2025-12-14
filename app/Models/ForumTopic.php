<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ForumTopic extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class);
    }

    // Relasi Like
    public function likes()
    {
        return $this->hasMany(ForumTopicLike::class);
    }

    // Helper: Cek apakah user login sudah like?
    public function isLikedByAuthUser()
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}
