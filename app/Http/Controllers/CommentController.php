<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Services\CommentModerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $moderationService;

    public function __construct(CommentModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    /**
     * Store a comment or reply.
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // Check if parent comment exists and belongs to the same article
        if (!empty($validated['parent_id'])) {
            $parent = Comment::findOrFail($validated['parent_id']);
            if ($parent->article_id !== $article->id) {
                return back()->withErrors(['body' => 'Parent comment tidak sesuai dengan artikel ini.']);
            }
        }

        // Check word whitelist
        if (!$this->moderationService->passes($validated['body'])) {
            return back()->withErrors([
                'body' => 'Komentar Anda tidak mengandung kata/kalimat yang diperbolehkan oleh admin.',
            ])->withInput();
        }

        Comment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        // Allow comment author or superadmin to delete
        if (Auth::id() !== $comment->user_id && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
