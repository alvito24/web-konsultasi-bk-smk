<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CounselingSession;
use App\Models\CounselingMaterial;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // Data Chart & Materi (Global)
        $chartData = CounselingSession::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(scheduled_at) as month_name"))
                    ->whereYear('scheduled_at', date('Y'))
                    ->groupBy(DB::raw("MONTHNAME(scheduled_at)"), DB::raw("MONTH(scheduled_at)"))
                    ->orderBy(DB::raw("MONTH(scheduled_at)"))
                    ->pluck('count', 'month_name');

        $topMaterials = CounselingMaterial::orderBy('views_count', 'desc')->take(5)->get();

        // 1. ADMIN
        if ($role === 'admin') {
            $data = [
                'total_siswa' => User::where('role', 'siswa')->count(),
                'total_guru' => User::whereIn('role', ['guru_bk', 'wali_kelas'])->count(),
                'jadwal_konseling' => CounselingSession::where('status', 'approved')->where('scheduled_at', '>=', now())->count(),
                'booking_aktif' => CounselingSession::where('status', 'pending')->count(),
                'booking_on_progress' => CounselingSession::where('status', 'approved')->count(),
                'booking_selesai' => CounselingSession::where('status', 'completed')->count(),
                'booking_pending' => CounselingSession::where('status', 'pending')->count(),
            ];
            return view('dashboard.admin', compact('data', 'chartData', 'topMaterials'));
        }

        // 2. GURU BK (REVISI: Filter hanya request milik dia)
        if ($role === 'guru_bk') {
            $data = [
                'slot_aktif' => \App\Models\CounselingSchedule::where('counselor_id', Auth::id())
                                ->where('date', '>=', now())
                                ->where('is_booked', false)
                                ->count(),
                // Request Masuk = Session Pending yang counselor_id nya adalah SAYA
                'permintaan_masuk' => CounselingSession::where('counselor_id', Auth::id())
                                        ->where('status', 'pending')->count(),
                'sesi_selesai' => CounselingSession::where('counselor_id', Auth::id())
                                ->where('status', 'completed')
                                ->count(),
            ];

            // List Pending Request spesifik Guru BK ini
            $pendingRequests = CounselingSession::with('student')
                                ->where('counselor_id', Auth::id())
                                ->where('status', 'pending')
                                ->orderBy('scheduled_at', 'asc')
                                ->get();

            return view('dashboard.guru_bk', compact('data', 'pendingRequests', 'chartData', 'topMaterials'));
        }

        // 3. SISWA
        if ($role === 'siswa') {
            $histories = CounselingSession::where('student_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
            return view('dashboard.siswa', compact('histories'));
        }

        // 4. WALI KELAS (REVISI: Dashboard mirip Guru BK tapi tanpa Kelola Jadwal)
        if ($role === 'wali_kelas') {
            return view('dashboard.wali_kelas', compact('chartData', 'topMaterials'));
        }

        return view('dashboard');
    }

    public function exportPdf()
    {
        if (!in_array(Auth::user()->role, ['guru_bk', 'wali_kelas', 'admin'])) abort(403);

        $sessions = CounselingSession::with(['student', 'counselor'])
                    ->where('status', 'completed')
                    ->orderBy('scheduled_at', 'desc')
                    ->get();

        $pdf = Pdf::loadView('reports.counseling_pdf', compact('sessions'));

        return $pdf->download('laporan-konseling-'.date('Y-m-d').'.pdf');
    }
}
