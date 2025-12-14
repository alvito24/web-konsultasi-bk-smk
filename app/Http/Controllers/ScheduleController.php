<?php

namespace App\Http\Controllers;

use App\Models\CounselingSchedule;
use App\Models\CounselingSession; // Import Session
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    // Halaman Khusus Manajemen Jadwal
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil Jadwal yang saya buat
        // PENTING: Load 'session.student' agar data siswa bisa diakses di view
        $mySchedules = CounselingSchedule::where('counselor_id', $userId)
            ->where('date', '>=', now())
            ->with(['session.student'])
            ->orderBy('date', 'asc')
            ->orderBy('time_slot', 'asc')
            ->get();

        // 2. Ambil Request Booking dari Siswa (Pending)
        $incomingRequests = CounselingSession::with('student')
            ->where('counselor_id', $userId)
            ->where('status', 'pending')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('counseling.schedule_index', compact('mySchedules', 'incomingRequests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'room_number' => 'required|string',
        ]);

        // 1. CEK BENTROK RUANGAN (Antar Guru)
        if (!str_contains(strtolower($request->room_number), 'online')) {
            $isBooked = CounselingSchedule::where('date', $request->date)
                ->where('time_slot', $request->time_slot)
                ->where('room_number', $request->room_number)
                ->exists();

            if ($isBooked) {
                return redirect()->back()->with('error', 'Gagal! Ruangan tersebut sudah dipakai guru lain pada sesi ini.');
            }
        }

        // 2. CEK BENTROK DIRI SENDIRI (New)
        // Biar guru gak punya 2 jadwal di jam yang sama
        $selfConflict = CounselingSchedule::where('counselor_id', Auth::id())
            ->where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->exists();

        if ($selfConflict) {
            return redirect()->back()->with('error', 'Anda sudah memiliki jadwal lain di jam tersebut.');
        }

        // 3. SIMPAN
        CounselingSchedule::create([
            'counselor_id' => Auth::id(),
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'room_number' => $request->room_number,
        ]);

        return redirect()->back()->with('success', 'Jadwal konseling berhasil dibuka!');
    }

    public function destroy(CounselingSchedule $schedule)
    {
        if ($schedule->counselor_id !== Auth::id()) {
            abort(403);
        }

        if ($schedule->is_booked) {
            return redirect()->back()->with('error', 'Gagal hapus! Jadwal ini sudah dibooking siswa.');
        }

        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }

    // Method untuk menampilkan Halaman Detail Sesi
    public function showSession(\App\Models\CounselingSession $session)
    {
        // Pastikan hanya guru yang bersangkutan yang bisa lihat
        if ($session->counselor_id !== Auth::id()) {
            abort(403);
        }

        return view('counseling.session_detail', compact('session'));
    }
}
