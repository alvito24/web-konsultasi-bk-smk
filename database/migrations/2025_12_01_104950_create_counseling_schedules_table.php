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
        Schema::create('counseling_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counselor_id')->constrained('users')->onDelete('cascade'); // Guru BK
            $table->date('date'); // Tanggal Konseling
            $table->string('time_slot'); // Jam/Sesi (misal: "08:00 - 09:00" atau "Sesi 1")
            $table->string('room_number'); // No. Ruang
            $table->boolean('is_booked')->default(false); // Status apakah sudah dibooking siswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_schedules');
    }
};
