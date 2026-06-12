<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Article::with(['user', 'media']);

        // If user is not superadmin, show only their own articles
        if (!auth()->user()->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $articles = $query->when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = auth()->user()->isSuperAdmin() ? User::all() : null;

        return view('articles.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'published_at' => 'nullable|date',
            'media.*' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov|max:51200',
        ];

        $request->validate($rules);

        $coverImage = null;
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')->store('covers', 'public');
        }

        $publishedAt = null;
        if ($request->status === 'published') {
            $publishedAt = $request->published_at ? Carbon::parse($request->published_at) : now();
        }

        $article = Article::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $publishedAt,
            'cover_image' => $coverImage,
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $path = $file->store('articles', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                Media::create([
                    'article_id' => $article->id,
                    'type' => $type,
                    'file_path' => $path,
                    'order' => $index,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::with(['user', 'media' => function($query) {
            $query->orderBy('order', 'asc');
        }])->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::with(['media' => function($query) {
            $query->orderBy('order', 'asc');
        }])->findOrFail($id);

        // Check authorization
        $this->authorizeArticle($article);

        $users = auth()->user()->isSuperAdmin() ? User::all() : null;

        return view('articles.edit', compact('article', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        // Check authorization
        $this->authorizeArticle($article);

        $rules = [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'published_at' => 'nullable|date',
            'media.*' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov|max:51200',
        ];

        // Only superadmin can change user_id
        if (auth()->user()->isSuperAdmin()) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        // Handle cover image
        $coverImage = $article->cover_image;
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if it was a standalone uploaded file (not from gallery)
            if ($article->cover_image && Storage::disk('public')->exists($article->cover_image)) {
                $hasGalleryMedia = $article->media()->where('file_path', $article->cover_image)->exists();
                if (!$hasGalleryMedia && str_starts_with($article->cover_image, 'covers/')) {
                    Storage::disk('public')->delete($article->cover_image);
                }
            }
            $coverImage = $request->file('cover_image')->store('covers', 'public');
        }

        $publishedAt = null;
        if ($request->status === 'published') {
            $publishedAt = $request->published_at ? Carbon::parse($request->published_at) : ($article->published_at ?: now());
        }

        $article->update([
            'user_id' => auth()->user()->isSuperAdmin() ? $request->user_id : $article->user_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $publishedAt,
            'cover_image' => $coverImage,
        ]);

        if ($request->hasFile('media')) {
            $maxOrder = $article->media()->max('order') ?? -1;
            foreach ($request->file('media') as $index => $file) {
                $path = $file->store('articles', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                Media::create([
                    'article_id' => $article->id,
                    'type' => $type,
                    'file_path' => $path,
                    'order' => $maxOrder + 1 + $index,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);

        // Check authorization
        $this->authorizeArticle($article);

        // File cleanup is handled in the Article model's static deleting event listener
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Upload additional media for an article via AJAX or standard form.
     */
    public function uploadMedia(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorizeArticle($article);

        $request->validate([
            'media' => 'required|array',
            'media.*' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:51200',
        ]);

        $maxOrder = $article->media()->max('order') ?? -1;
        $uploaded = [];

        foreach ($request->file('media') as $index => $file) {
            $path = $file->store('articles', 'public');
            $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

            $media = Media::create([
                'article_id' => $article->id,
                'type' => $type,
                'file_path' => $path,
                'order' => $maxOrder + 1 + $index,
                'created_by' => auth()->id(),
            ]);

            $uploaded[] = [
                'id' => $media->id,
                'type' => $media->type,
                'url' => asset('storage/' . $media->file_path),
                'caption' => $media->caption,
                'order' => $media->order,
            ];
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'media' => $uploaded]);
        }

        return redirect()->back()->with('success', 'Media berhasil diunggah.');
    }

    /**
     * Reorder media items via AJAX.
     */
    public function reorderMedia(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorizeArticle($article);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|exists:media,id',
        ]);

        foreach ($request->order as $index => $mediaId) {
            Media::where('article_id', $article->id)
                ->where('id', $mediaId)
                ->update(['order' => $index]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Urutan media berhasil disimpan.');
    }

    /**
     * Set cover image from existing gallery media or clear it.
     */
    public function setCover(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorizeArticle($article);

        $request->validate([
            'media_id' => 'nullable|exists:media,id',
        ]);

        if ($request->media_id) {
            $media = Media::where('article_id', $article->id)->findOrFail($request->media_id);
            if ($media->type !== 'image') {
                return response()->json(['error' => 'Cover harus berupa gambar.'], 422);
            }
            $coverPath = $media->file_path;
        } else {
            $coverPath = null;
        }

        $article->update([
            'cover_image' => $coverPath,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cover_image_url' => $coverPath ? asset('storage/' . $coverPath) : null
            ]);
        }

        return redirect()->back()->with('success', 'Cover image berhasil diperbarui.');
    }

    /**
     * Delete media item and clean up storage.
     */
    public function destroyMedia(string $id)
    {
        $media = Media::findOrFail($id);
        $article = $media->article;

        if (!auth()->user()->isSuperAdmin() && $article->user_id !== auth()->id()) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'Akses ditolak.'], 403);
            }
            abort(403);
        }

        // If this media is the cover, clear it
        if ($article->cover_image === $media->file_path) {
            $article->update(['cover_image' => null]);
        }

        // Delete file
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Media berhasil dihapus.');
    }

    /**
     * Update caption of media item.
     */
    public function updateMedia(Request $request, string $id)
    {
        $media = Media::findOrFail($id);
        $article = $media->article;

        if (!auth()->user()->isSuperAdmin() && $article->user_id !== auth()->id()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Akses ditolak.'], 403);
            }
            abort(403);
        }

        $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $media->update([
            'caption' => $request->caption,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Caption berhasil diperbarui.');
    }

    /**
     * Quick status publish toggle.
     */
    public function togglePublish(string $id)
    {
        $article = Article::findOrFail($id);
        $this->authorizeArticle($article);

        if ($article->status === 'published') {
            $article->update([
                'status' => 'draft',
                'published_at' => null,
            ]);
            $msg = 'Status artikel diubah menjadi Draft.';
        } else {
            $article->update([
                'status' => 'published',
                'published_at' => now(),
            ]);
            $msg = 'Artikel berhasil dipublikasikan.';
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Authorize article access
     */
    private function authorizeArticle(Article $article): void
    {
        if (!auth()->user()->isSuperAdmin() && $article->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengakses artikel ini.');
        }
    }
}
