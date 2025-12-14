<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewBookingAlert;
use App\Mail\BookingStatusUpdate;
use App\Models\User;
use App\Models\CounselingSession;
use App\Models\CounselingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselingSessionController extends Controller
{
    public function create()
    {
        $availableSchedules = CounselingSchedule::where('is_booked', false)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->with('counselor')
            ->orderBy('date', 'asc')
            ->orderBy('time_slot', 'asc')
            ->get();

        return view('counseling.create', compact('availableSchedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:counseling_schedules,id',
            'category' => 'required|string',
            'problem_description' => 'nullable|string',
        ]);

        $schedule = CounselingSchedule::find($request->schedule_id);

        // Cek booking, TAPI karena logic baru membolehkan request pending tanpa lock,
        // validasi ini mencegah double booking hanya jika sudah APPROVED orang lain.
        if ($schedule->is_booked) {
            return redirect()->back()->with('error', 'Yah, jadwal ini sudah disetujui untuk siswa lain!');
        }

        $session = CounselingSession::create([
            'student_id' => Auth::id(),
            'counselor_id' => $schedule->counselor_id,
            'scheduled_at' => $schedule->date->format('Y-m-d') . ' ' . substr($schedule->time_slot, 0, 5),
            'type' => str_contains(strtolower($schedule->room_number), 'online') ? 'online' : 'onsite',
            'category' => $request->category,
            'problem_description' => $request->problem_description,
            'status' => 'pending',
        ]);

        // REVISI ALUR: JANGAN KUNCI JADWAL DULU.
        // $schedule->update(['is_booked' => true]); <--- INI DIHAPUS

        if ($schedule->counselor) {
            Mail::to($schedule->counselor->email)->send(new NewBookingAlert($session));
        }

        return redirect()->route('dashboard')->with('success', 'Permintaan terkirim! Menunggu persetujuan Guru BK.');
    }

    public function updateStatus(Request $request, CounselingSession $session)
    {
        if (Auth::user()->role !== 'guru_bk') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,completed,cancelled',
            'counselor_notes' => 'nullable|string'
        ]);

        // Update status sesi
        $session->update([
            'status' => $request->status,
            'counselor_id' => Auth::id(),
            'counselor_notes' => $request->counselor_notes
        ]);

        // SINKRONISASI JADWAL
        // Cari jadwal yang tanggal & jamnya cocok
        $date = $session->scheduled_at->format('Y-m-d');
        $timeStart = $session->scheduled_at->format('H:i');

        $schedule = CounselingSchedule::where('counselor_id', $session->counselor_id)
                    ->where('date', $date)
                    ->where('time_slot', 'like', "$timeStart%")
                    ->first();

        if ($schedule) {
            if ($request->status === 'approved') {
                // REVISI ALUR: Kalau disetujui, BARU KUNCI JADWALNYA
                $schedule->update(['is_booked' => true]);
            }
            elseif (in_array($request->status, ['rejected', 'cancelled'])) {
                // Kalau ditolak/batal, pastikan jadwal TERBUKA (Available)
                $schedule->update(['is_booked' => false]);
            }
            // Kalau completed, biarkan status terakhir (biasanya true/booked sebagai history)
        }

        if ($session->student) {
            Mail::to($session->student->email)->send(new BookingStatusUpdate($session));
        }

        return redirect()->back()->with('success', 'Status permintaan berhasil diperbarui.');
    }
}
