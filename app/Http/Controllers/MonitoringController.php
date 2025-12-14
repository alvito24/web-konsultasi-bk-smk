<?php

namespace App\Http\Controllers;

use App\Models\CounselingSession;
use App\Models\CounselingSchedule;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    // 1. Monitoring Jadwal Konseling (Semua jadwal yang dibuat Guru)
    public function schedules()
    {
        // Ambil semua jadwal, urutkan dari yang terbaru/terdekat
        $schedules = CounselingSchedule::with('counselor')
                        ->where('date', '>=', now()) // Hanya jadwal masa depan
                        ->orderBy('date', 'asc')
                        ->orderBy('time_slot', 'asc')
                        ->paginate(10);

        return view('admin.monitoring.schedules', compact('schedules'));
    }

    // 2. Monitoring Booking Aktif (Semua sesi yang statusnya pending/approved)
    public function bookings()
    {
        $bookings = CounselingSession::with(['student', 'counselor'])
                        ->whereIn('status', ['pending', 'approved']) // Hanya yang aktif
                        ->orderBy('scheduled_at', 'asc')
                        ->paginate(10);

        return view('admin.monitoring.bookings', compact('bookings'));
    }
}
