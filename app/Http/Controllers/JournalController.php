<?php

namespace App\Http\Controllers;

use App\Models\DailyJournal;
use App\Models\JournalFeedback; // Import Model Baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    // --- SISWA ---
    public function index()
    {
        $journals = DailyJournal::where('user_id', Auth::id())
            ->with(['feedbacks.teacher']) // Load feedback dari guru
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('journals.index', compact('journals'));
    }

    public function create()
    {
        return view('journals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'mood' => 'required|string',
            'content' => 'required|string',
            'is_public' => 'required|boolean',
        ]);

        DailyJournal::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'mood' => $request->mood,
            'content' => $request->content,
            'is_public' => $request->is_public,
        ]);

        return redirect()->route('journal.index')->with('success', 'Jurnal harian berhasil disimpan!');
    }

    public function show(DailyJournal $journal)
    {
        if ($journal->user_id !== Auth::id()) abort(403);
        return view('journals.show', compact('journal'));
    }

    public function edit(DailyJournal $journal)
    {
        if ($journal->user_id !== Auth::id()) abort(403);
        return view('journals.edit', compact('journal'));
    }

    public function update(Request $request, DailyJournal $journal)
    {
        if ($journal->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'mood' => 'required|string',
            'content' => 'required|string',
            'is_public' => 'required|boolean',
        ]);

        $journal->update([
            'title' => $request->title,
            'mood' => $request->mood,
            'content' => $request->content,
            'is_public' => $request->is_public,
        ]);

        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(DailyJournal $journal)
    {
        if ($journal->user_id !== Auth::id()) abort(403);
        $journal->delete();
        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil dihapus.');
    }

    // --- GURU BK / WALI KELAS ---

    // REVISI: Filter feedback berdasarkan Session Guru yang login
    public function reviewIndex(Request $request)
    {
        if (!in_array(Auth::user()->role, ['guru_bk', 'wali_kelas'])) abort(403);

        $userId = Auth::id();

        // Query Jurnal Public
        $query = DailyJournal::where('is_public', true)
                    ->with(['user', 'feedbacks' => function($q) use ($userId) {
                        // Hanya ambil feedback yang dibuat oleh guru yang sedang login ini
                        $q->where('teacher_id', $userId);
                    }]);

        // Logic Filter Tab (Sudah direview SAYA atau Belum)
        if ($request->filter == 'reviewed') {
            $query->whereHas('feedbacks', function($q) use ($userId) {
                $q->where('teacher_id', $userId);
            });
        } elseif ($request->filter == 'unreviewed') {
            $query->whereDoesntHave('feedbacks', function($q) use ($userId) {
                $q->where('teacher_id', $userId);
            });
        }

        $journals = $query->orderBy('created_at', 'desc')->paginate(10);

        // Hitung Counter (Khusus Guru Ini)
        $countAll = DailyJournal::where('is_public', true)->count();

        $countReviewed = DailyJournal::where('is_public', true)
            ->whereHas('feedbacks', function($q) use ($userId) {
                $q->where('teacher_id', $userId);
            })->count();

        $countUnreviewed = $countAll - $countReviewed;

        return view('journals.review_index', compact('journals', 'countAll', 'countReviewed', 'countUnreviewed'));
    }

    // REVISI: Simpan Feedback ke tabel journal_feedbacks
    public function storeFeedback(Request $request, DailyJournal $journal)
    {
        if (!in_array(Auth::user()->role, ['guru_bk', 'wali_kelas'])) abort(403);

        $request->validate(['teacher_feedback' => 'required|string']);

        // Pakai updateOrCreate:
        // Jika Guru ini sudah pernah komen di jurnal ini -> Update
        // Jika belum -> Create baru
        JournalFeedback::updateOrCreate(
            [
                'daily_journal_id' => $journal->id,
                'teacher_id' => Auth::id(),
            ],
            [
                'content' => $request->teacher_feedback
            ]
        );

        return redirect()->back()->with('success', 'Feedback berhasil dikirim.');
    }
}
