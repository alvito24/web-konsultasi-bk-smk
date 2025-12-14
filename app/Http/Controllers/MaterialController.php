<?php

namespace App\Http\Controllers;

use App\Models\CounselingMaterial;
use App\Models\MaterialUpvote; // Import model baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    // 1. Browser Materi (Filter + Populer Logic)
    public function index(Request $request)
    {
        $query = CounselingMaterial::with(['uploader'])->withCount('upvotes');

        // A. Filter Pencarian (Judul)
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // B. Filter Kategori (Dropdown) - REVISI
        if ($request->category) {
            $query->where('category', $request->category);
        }

        $materials = $query->orderBy('created_at', 'desc')->paginate(9);

        // C. Materi Terpopuler (Sort by Upvotes terbanyak, lalu Views terbanyak) - REVISI
        $popularMaterials = CounselingMaterial::withCount('upvotes')
                            ->orderBy('upvotes_count', 'desc')
                            ->orderBy('views_count', 'desc')
                            ->take(5)
                            ->get();

        return view('materials.index', compact('materials', 'popularMaterials'));
    }

    // 2. Logic Upvote (Toggle) - NEW FEATURE
    public function upvote($id)
    {
        $material = CounselingMaterial::findOrFail($id);
        $userId = Auth::id();

        // Cek apakah sudah like?
        $existingUpvote = MaterialUpvote::where('counseling_material_id', $id)
                            ->where('user_id', $userId)
                            ->first();

        if ($existingUpvote) {
            // Kalau sudah ada -> Hapus (Unlike)
            $existingUpvote->delete();
            $msg = 'Upvote dibatalkan.';
        } else {
            // Kalau belum ada -> Buat (Like)
            MaterialUpvote::create([
                'counseling_material_id' => $id,
                'user_id' => $userId
            ]);
            $msg = 'Materi berhasil di-upvote!';
        }

        return redirect()->back()->with('success', $msg);
    }

    // --- METHOD CRUD LAINNYA TETAP SAMA ---

    public function create()
    {
        // Security Check
        if (!in_array(Auth::user()->role, ['guru_bk', 'wali_kelas'])) {
            abort(403, 'Akses ditolak.');
        }
        return view('materials.create');
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['guru_bk', 'wali_kelas'])) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'type_selection' => 'required|in:file,youtube',
            'file_upload' => 'required_if:type_selection,file|file|mimes:pdf,jpg,jpeg,png,mp4,mov|max:51200',
            'youtube_link' => 'required_if:type_selection,youtube|nullable|url',
        ]);

        $filePath = null;
        $fileType = 'text';

        if ($request->type_selection === 'file') {
            $file = $request->file('file_upload');
            $filePath = $file->store('materials', 'public');

            $ext = $file->getClientOriginalExtension();
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) $fileType = 'image';
            elseif (in_array($ext, ['mp4', 'mov'])) $fileType = 'video';
            elseif ($ext === 'pdf') $fileType = 'pdf';

        } else {
            $filePath = $request->youtube_link;
            $fileType = 'youtube';
        }

        CounselingMaterial::create([
            'uploaded_by' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_type' => $fileType,
        ]);

        return redirect()->route('materials.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    public function show(CounselingMaterial $material)
    {
        $material->increment('views_count');
        return view('materials.show', compact('material'));
    }

    public function destroy(CounselingMaterial $material)
    {
        if ($material->uploaded_by !== Auth::id()) abort(403);

        if ($material->file_type !== 'youtube') {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        return redirect()->back()->with('success', 'Materi dihapus.');
    }
}
