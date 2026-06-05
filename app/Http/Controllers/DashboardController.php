<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard home screen.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalArticles = Article::count();

        // Let's also fetch a few recent items to populate the dashboard and make it feel alive!
        $recentArticles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('totalUsers', 'totalArticles', 'recentArticles', 'recentUsers'));
    }
}
