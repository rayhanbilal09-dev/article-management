<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Article::with('user');

        // If user is not superadmin, show only their own articles
        if (!auth()->user()->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $articles = $query->when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
        })->paginate(10);

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
        ];

        // Only superadmin can select user_id
        if (auth()->user()->isSuperAdmin()) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        Article::create([
            'user_id' => auth()->user()->isSuperAdmin() ? $request->user_id : auth()->id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::with('user')->findOrFail($id);

        // Check authorization
        $this->authorizeArticle($article);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);

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
        ];

        // Only superadmin can change user_id
        if (auth()->user()->isSuperAdmin()) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        $article->update([
            'user_id' => auth()->user()->isSuperAdmin() ? $request->user_id : $article->user_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->status === 'published'
                ? ($article->published_at ?: now())
                : null,
        ]);

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

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus.');
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
