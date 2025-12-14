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
        Schema::table('counseling_materials', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title'); // Tambah Deskripsi
            // Ubah file_type jadi string biasa biar fleksibel (pdf, image, video, youtube)
            $table->string('file_type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
