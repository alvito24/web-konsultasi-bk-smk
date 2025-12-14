<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\ForumReply;
use App\Models\ForumTopicLike;
use App\Models\ForumReplyLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // 1. Index dengan Sorting & Filtering
    public function index(Request $request)
    {
        $query = ForumTopic::with('user')
                    ->withCount(['replies', 'likes']); // Hitung reply & likes

        // Filter Kategori
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Filter Pencarian
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting (Terpopuler / Terbaru)
        if ($request->sort === 'popular') {
            $query->orderBy('likes_count', 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); // Default Terbaru
        }

        $topics = $query->paginate(10);

        // Sidebar: Topik Populer (Top 5)
        $popularTopics = ForumTopic::withCount('likes')
                            ->orderBy('likes_count', 'desc')
                            ->take(5)
                            ->get();

        return view('forum.index', compact('topics', 'popularTopics'));
    }

    // 2. Logic Like Topik
    public function likeTopic($id)
    {
        $topic = ForumTopic::findOrFail($id);
        $userId = Auth::id();

        $existingLike = ForumTopicLike::where('forum_topic_id', $id)->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete(); // Unlike
        } else {
            ForumTopicLike::create(['forum_topic_id' => $id, 'user_id' => $userId]); // Like
        }

        return redirect()->back();
    }

    // 3. Logic Like Reply (Komentar)
    public function likeReply($id)
    {
        $reply = ForumReply::findOrFail($id);
        $userId = Auth::id();

        $existingLike = ForumReplyLike::where('forum_reply_id', $id)->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete(); // Unlike
        } else {
            ForumReplyLike::create(['forum_reply_id' => $id, 'user_id' => $userId]); // Like
        }

        return redirect()->back();
    }

    // --- FITUR SEBELUMNYA (Create, Store, Show, Reply, Destroy, Toggle) TETAP SAMA ---

    public function create()
    {
        if (!in_array(Auth::user()->role, ['guru_bk', 'wali_kelas'])) abort(403);
        return view('forum.create');
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['guru_bk', 'wali_kelas'])) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        ForumTopic::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => true,
        ]);

        return redirect()->route('forum.index')->with('success', 'Topik diskusi berhasil dibuat!');
    }

    public function show(ForumTopic $forum)
    {
        // Load replies beserta usernya DAN hitung likes-nya
        $forum->load(['user', 'replies.user']);
        $forum->loadCount('likes'); // Hitung like topik

        // Eager load likes count untuk setiap reply biar efisien
        $forum->replies->loadCount('likes');

        return view('forum.show', compact('forum'));
    }

    public function reply(Request $request, ForumTopic $forum)
    {
        if (!$forum->is_active) {
            return redirect()->back()->with('error', 'Topik ini sudah ditutup.');
        }

        $request->validate(['content' => 'required|string']);

        ForumReply::create([
            'forum_topic_id' => $forum->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Komentar terkirim.');
    }

    public function destroyReply(ForumReply $reply)
    {
        $user = Auth::user();

        $isAuthorized =
            $user->role === 'admin' ||
            $reply->user_id === $user->id ||
            $reply->topic->user_id === $user->id;

        if (!$isAuthorized) abort(403);

        $reply->delete();
        return redirect()->back()->with('success', 'Komentar dihapus.');
    }

    public function toggleStatus(ForumTopic $forum)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $forum->user_id) {
            abort(403);
        }

        $forum->update(['is_active' => !$forum->is_active]);
        return redirect()->back()->with('success', 'Status diskusi diperbarui.');
    }
}
