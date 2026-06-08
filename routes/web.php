<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicArticleController;
use Illuminate\Support\Facades\Route;

// Public Routes (Blog)
Route::get('/blog', [PublicArticleController::class, 'index'])->name('public.articles.index');
Route::get('/blog/{slug}', [PublicArticleController::class, 'show'])->name('public.articles.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Superadmin Routes
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Articles Routes (both superadmin and user can access)
    Route::resource('articles', ArticleController::class);
});

