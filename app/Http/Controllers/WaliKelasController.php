<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CounselingSchedule; // Import
use App\Models\CounselingSession; // Import
use App\Mail\NewBookingAlert; // Import Email
use Illuminate\Support\Facades\Mail; // Import Email Facade
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliKelasController extends Controller
{
    public function myStudents()
    {
        if (Auth::user()->role !== 'wali_kelas') abort(403);

        $myClass = Auth::user()->class_name;

        if (!$myClass) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        $students = User::where('role', 'siswa')
                        ->where('class_name', $myClass)
                        ->orderBy('name')
                        ->get();

        return view('wali_kelas.students', compact('students', 'myClass'));
    }

    // --- NEW: BOOKING UNTUK WALI KELAS ---

    public function createBooking()
    {
        if (Auth::user()->role !== 'wali_kelas') abort(403);

        $myClass = Auth::user()->class_name;

        // 1. Ambil Siswa di kelasnya
        $students = User::where('role', 'siswa')
                        ->where('class_name', $myClass)
                        ->orderBy('name')
                        ->get();

        // 2. Ambil Jadwal Tersedia
        $availableSchedules = CounselingSchedule::where('is_booked', false)
                                ->where('date', '>=', now()->format('Y-m-d'))
                                ->with('counselor')
                                ->orderBy('date', 'asc')
                                ->orderBy('time_slot', 'asc')
                                ->get();

        return view('wali_kelas.booking_create', compact('students', 'availableSchedules'));
    }

    public function storeBooking(Request $request)
    {
        if (Auth::user()->role !== 'wali_kelas') abort(403);

        $request->validate([
            'student_id' => 'required|exists:users,id', // Harus pilih siswa
            'schedule_id' => 'required|exists:counseling_schedules,id',
            'category' => 'required|string',
            'problem_description' => 'nullable|string',
        ]);

        $schedule = CounselingSchedule::find($request->schedule_id);

        if ($schedule->is_booked) {
            return redirect()->back()->with('error', 'Yah, jadwal ini baru saja diambil orang lain!');
        }

        // Simpan Sesi (student_id nya dari pilihan dropdown, bukan Auth::id())
        $session = CounselingSession::create([
            'student_id' => $request->student_id,
            'counselor_id' => $schedule->counselor_id,
            'scheduled_at' => $schedule->date->format('Y-m-d') . ' ' . substr($schedule->time_slot, 0, 5),
            'type' => str_contains(strtolower($schedule->room_number), 'online') ? 'online' : 'onsite',
            'category' => $request->category,
            'problem_description' => $request->problem_description . ' (Dibooking oleh Wali Kelas: ' . Auth::user()->name . ')',
            'status' => 'pending',
        ]);

        $schedule->update(['is_booked' => true]);

        // Kirim Notifikasi Email ke Guru BK
        if ($schedule->counselor) {
            Mail::to($schedule->counselor->email)->send(new NewBookingAlert($session));
        }

        return redirect()->route('dashboard')->with('success', 'Berhasil mem-booking konseling untuk siswa.');
    }
}
