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
        Schema::table('daily_journals', function (Blueprint $table) {
            $table->string('title')->after('user_id'); // Judul Jurnal
            $table->text('teacher_feedback')->nullable()->after('is_public'); // Rekomendasi Guru
            $table->timestamp('feedback_at')->nullable(); // Kapan direview
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_journals', function (Blueprint $table) {
            //
        });
    }
};
