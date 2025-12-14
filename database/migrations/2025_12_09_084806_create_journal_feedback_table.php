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
        // KITA PAKAI NAMA PLURAL: 'journal_feedbacks'
        Schema::create('journal_feedbacks', function (Blueprint $table) {
            $table->id();

            // Pastikan referensi ke tabel 'daily_journals' (sesuaikan nama tabel jurnal lu)
            $table->foreignId('daily_journal_id')->constrained('daily_journals')->onDelete('cascade');

            // Referensi ke user (guru)
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');

            $table->text('content'); // Isi masukan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // HAPUS TABEL DENGAN NAMA YANG SAMA (PLURAL)
        Schema::dropIfExists('journal_feedbacks');
    }
};
