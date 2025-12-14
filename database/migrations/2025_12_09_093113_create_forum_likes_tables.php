<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Like untuk Topik Utama
        Schema::create('forum_topic_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('forum_topic_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            // Satu user cuma bisa like 1x per topik
            $table->unique(['user_id', 'forum_topic_id']);
        });

        // 2. Tabel Like untuk Komentar/Reply
        Schema::create('forum_reply_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('forum_reply_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            // Satu user cuma bisa like 1x per reply
            $table->unique(['user_id', 'forum_reply_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_likes_tables');
    }
};
