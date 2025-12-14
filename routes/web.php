<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CounselingSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\WaliKelasController; // Pastikan controller ini diimport
use App\Http\Controllers\MonitoringController; // Import monitoring controller
use App\Http\Controllers\ForumController; // Import forum controller
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- GROUP ROUTE AUTH ---
Route::middleware('auth')->group(function () {

    // 1. SETUP PROFIL
    Route::get('/profile/setup', [ProfileSetupController::class, 'create'])->name('profile.setup');
    Route::post('/profile/setup', [ProfileSetupController::class, 'store'])->name('profile.setup.store');

    // 2. ROUTE UTAMA (Wajib Profil Lengkap)
    Route::middleware('profile.complete')->group(function () {

        // DASHBOARD & PROFILE
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // KONSELING (Siswa & Admin)
        Route::middleware('role:siswa,admin')->group(function () {
            Route::get('/counseling/create', [CounselingSessionController::class, 'create'])->name('counseling.create');
            Route::post('/counseling', [CounselingSessionController::class, 'store'])->name('counseling.store');
        });

        // GURU BK (Jadwal & Approval)
        Route::middleware('role:guru_bk')->group(function () {
            Route::patch('/counseling/{session}/update-status', [CounselingSessionController::class, 'updateStatus'])->name('counseling.update-status');
            Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
            Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
            // Halaman Jadwal Terpisah
            Route::get('/counseling/schedule', [ScheduleController::class, 'index'])->name('counseling.schedule');
            // NEW: Route untuk halaman detail sesi
            Route::get('/counseling/session/{session}', [ScheduleController::class, 'showSession'])->name('counseling.show_session');
        });

        // --- ADMIN (MANAGE USER) ---
        Route::middleware('role:admin')->group(function () {
            // SISWA
            Route::get('/admin/students', [AdminController::class, 'indexSiswa'])->name('admin.students.index');
            Route::get('/admin/students/create', [AdminController::class, 'createSiswa'])->name('admin.students.create');
            Route::post('/admin/students', [AdminController::class, 'storeSiswa'])->name('admin.students.store');
            // Route Baru CRUD
            Route::get('/admin/students/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.students.edit');
            Route::put('/admin/students/{id}', [AdminController::class, 'updateSiswa'])->name('admin.students.update');
            Route::delete('/admin/students/{id}', [AdminController::class, 'destroySiswa'])->name('admin.students.destroy');

            // GURU
            Route::get('/admin/teachers', [AdminController::class, 'indexGuru'])->name('admin.teachers.index');
            Route::get('/admin/teachers/create', [AdminController::class, 'createGuru'])->name('admin.teachers.create');
            Route::post('/admin/teachers', [AdminController::class, 'storeGuru'])->name('admin.teachers.store');
            // Route Baru CRUD
            Route::get('/admin/teachers/{id}/edit', [AdminController::class, 'editGuru'])->name('admin.teachers.edit');
            Route::put('/admin/teachers/{id}', [AdminController::class, 'updateGuru'])->name('admin.teachers.update');
            Route::delete('/admin/teachers/{id}', [AdminController::class, 'destroyGuru'])->name('admin.teachers.destroy');
        });

        // --- MONITORING (ADMIN & GURU BK) ---
        // Izin dibuka untuk guru_bk agar bisa lihat jadwal rekan
        Route::middleware('role:admin,guru_bk')->group(function () {
            Route::get('/admin/monitoring/schedules', [MonitoringController::class, 'schedules'])->name('admin.monitoring.schedules');
            Route::get('/admin/monitoring/bookings', [MonitoringController::class, 'bookings'])->name('admin.monitoring.bookings');
        });

        // --- JURNAL HARIAN (SISWA & ADMIN) ---
        Route::middleware('role:siswa,admin')->group(function () {
            Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
            Route::get('/journal/create', [JournalController::class, 'create'])->name('journal.create');
            Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');
            Route::get('/journal/{journal}', [JournalController::class, 'show'])->name('journal.show'); // Detail

            // NEW: Edit & Delete
            Route::get('/journal/{journal}/edit', [JournalController::class, 'edit'])->name('journal.edit');
            Route::put('/journal/{journal}', [JournalController::class, 'update'])->name('journal.update');
            Route::delete('/journal/{journal}', [JournalController::class, 'destroy'])->name('journal.destroy');
        });

        // REVIEW JURNAL (Guru BK & Wali Kelas)
        Route::middleware('role:guru_bk,wali_kelas')->group(function () {
            Route::get('/teacher/journals', [JournalController::class, 'reviewIndex'])->name('journal.review');
            Route::post('/journal/{journal}/feedback', [JournalController::class, 'storeFeedback'])->name('journal.feedback');
        });

        // --- BANK MATERI (SEMUA ROLE BISA LIHAT & UPVOTE) ---
        Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
        Route::post('/materials/{material}/upvote', [MaterialController::class, 'upvote'])->name('materials.upvote'); // NEW ROUTE

        // --- UPLOAD MATERI (KHUSUS GURU BK) ---
        Route::middleware('role:guru_bk,wali_kelas')->group(function () {
            Route::get('/materials/create/new', [MaterialController::class, 'create'])->name('materials.create');
            Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
            Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
        });

        // --- FORUM DISKUSI (SEMUA ROLE) ---
        Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
        Route::get('/forum/{forum}', [ForumController::class, 'show'])->name('forum.show');
        Route::post('/forum/{forum}/reply', [ForumController::class, 'reply'])->name('forum.reply');

        // NEW: Routes Like
        Route::post('/forum/topic/{id}/like', [ForumController::class, 'likeTopic'])->name('forum.topic.like');
        Route::post('/forum/reply/{id}/like', [ForumController::class, 'likeReply'])->name('forum.reply.like');

        // Hapus Komentar
        Route::delete('/forum/reply/{reply}', [ForumController::class, 'destroyReply'])->name('forum.reply.destroy');

        // --- REPORTING (Admin, Guru BK, Wali Kelas) ---
        Route::middleware('role:admin,guru_bk,wali_kelas')->group(function () {
            Route::get('/report/export-pdf', [DashboardController::class, 'exportPdf'])->name('report.export_pdf');
        });

        // --- KELOLA FORUM (GURU BK & WALI KELAS & ADMIN) ---
        Route::middleware('role:guru_bk,wali_kelas,admin')->group(function () {
            Route::get('/forum/create/new', [ForumController::class, 'create'])->name('forum.create');
            Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
            Route::patch('/forum/{forum}/toggle', [ForumController::class, 'toggleStatus'])->name('forum.toggle');
        });

        // --- KHUSUS WALI KELAS ---
        Route::middleware('role:wali_kelas')->group(function () {
            Route::get('/my-class/students', [WaliKelasController::class, 'myStudents'])->name('wali.students');

            // NEW: Booking Routes
            Route::get('/my-class/booking', [WaliKelasController::class, 'createBooking'])->name('wali.booking.create');
            Route::post('/my-class/booking', [WaliKelasController::class, 'storeBooking'])->name('wali.booking.store');
        });
    });
});

require __DIR__ . '/auth.php';
