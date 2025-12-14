<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ForumReply extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'forum_topic_id');
    }

    // Relasi Like
    public function likes()
    {
        return $this->hasMany(ForumReplyLike::class);
    }

    // Helper: Cek apakah user login sudah like?
    public function isLikedByAuthUser()
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}
