<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PublicArticleController extends Controller
{
    /**
     * Display a listing of published articles
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $articles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('public.articles.index', compact('articles', 'search'));
    }

    /**
     * Display the specified published article
     */
    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->with(['user', 'media' => function($query) {
                $query->orderBy('order', 'asc');
            }])
            ->firstOrFail();

        return view('public.articles.show', compact('article'));
    }
}
