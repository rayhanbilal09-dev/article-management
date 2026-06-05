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

    $articles = Article::with('user')
        ->when($search, function ($query) use ($search) {

            $query->where('title', 'like', "%{$search}%");

        })
        ->paginate(10);

    return view('articles.index', compact('articles'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $users = User::all();

    return view('articles.create', compact('users'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        Article::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::with('user')->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        $users = User::all();

        return view('articles.edit', compact('article', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        $article->update([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->status === 'published'
                ? ($article->published_at ?: now())
                : null,
        ]);

        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index');
    }
}
