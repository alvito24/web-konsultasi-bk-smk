<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users Table (Modified for Role & Profile)
        // Cover: Register, Login, Profile Mgmt, Verifikasi Identitas
        // 1. Users Table (Modified for First Login Flow)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nis_nip')->nullable()->unique(); // NIS/NIP
            $table->string('password'); // Default dari admin nanti

            // Roles
            $table->enum('role', ['admin', 'guru_bk', 'wali_kelas', 'siswa'])->default('siswa');

            // Profile Data (Nullable karena diisi user saat login pertama)
            $table->string('phone')->nullable();
            $table->string('class_name')->nullable(); // Kelas (Siswa)
            $table->text('interests')->nullable(); // Minat Bakat (Siswa)
            $table->text('career_goals')->nullable(); // Rencana Karir (Siswa)
            $table->string('avatar')->nullable(); // Foto Profil

            // Logic First Login
            $table->boolean('is_profile_complete')->default(false); // False = harus update profile dulu

            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Password Reset Tokens (Default Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Counseling Sessions (Fitur Konseling)
        // Cover: Booking, Pilih Peserta, Kategori, Catatan Solusi
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('counselor_id')->nullable()->constrained('users')->onDelete('set null'); // Guru BK
            $table->foreignId('parent_id')->nullable()->constrained('users')->onDelete('set null'); // Jika orangtua diundang

            $table->dateTime('scheduled_at');
            $table->enum('type', ['online', 'onsite']);
            $table->string('category'); // Akademik, Sosial, Pribadi, dll
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled', 'rejected'])->default('pending');
            $table->text('problem_description')->nullable();

            // Hasil konseling (Encrypted nanti di Model via Casts)
            $table->text('counselor_notes')->nullable();
            $table->text('solution')->nullable();

            $table->timestamps();
        });

        // 4. Daily Journals (Jurnal Harian Siswa)
        // Cover: Entry jurnal, Mood, Private/Public
        Schema::create('daily_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('mood'); // Senang, Sedih, Marah, dll
            $table->text('content'); // Cerita hari ini
            $table->boolean('is_public')->default(false); // Private vs Public (bisa dibaca Guru BK)
            $table->timestamps();
        });

        // 5. Discussion Forum (Forum Diskusi Positif)
        // Cover: Buat topik, Komentar, Moderasi
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pembuat topik (Guru BK/Wali Kelas)
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->boolean('is_active')->default(true); // Untuk non-aktifkan topik
            $table->timestamps();
        });

        Schema::create('forum_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_topic_id')->constrained('forum_topics')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // 6. Counseling Materials (Bank Materi)
        // Cover: Upload, Kategori, Preview
        Schema::create('counseling_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by')->constrained('users'); // Guru BK
            $table->string('title');
            $table->string('file_path'); // Path file PDF/Video
            $table->enum('file_type', ['pdf', 'video', 'text']);
            $table->string('category'); // Motivasi, Stres, Komunikasi
            $table->integer('views_count')->default(0); // Untuk "Materi paling banyak diakses"
            $table->timestamps();
        });

        // 7. Notifications (Bisa pakai table default Laravel 'notifications' tapi ini custom simple)
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->string('type'); // 'counseling_reminder', 'journal_feedback', etc
            $table->timestamps();
        });

        // 8. Sessions Table (WAJIB ADA untuk Login)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 9. Cache Table (Opsional tapi bagus buat performa nanti)
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
        Schema::dropIfExists('counseling_materials');
        Schema::dropIfExists('forum_replies');
        Schema::dropIfExists('forum_topics');
        Schema::dropIfExists('daily_journals');
        Schema::dropIfExists('counseling_sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
