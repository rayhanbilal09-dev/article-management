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

    // Media management & publishing workflow routes
    Route::post('articles/{article}/media', [ArticleController::class, 'uploadMedia'])->name('articles.media.upload');
    Route::post('articles/{article}/media/reorder', [ArticleController::class, 'reorderMedia'])->name('articles.media.reorder');
    Route::post('articles/{article}/set-cover', [ArticleController::class, 'setCover'])->name('articles.set-cover');
    Route::post('articles/{article}/toggle-publish', [ArticleController::class, 'togglePublish'])->name('articles.toggle-publish');
    Route::delete('media/{media}', [ArticleController::class, 'destroyMedia'])->name('media.destroy');
    Route::put('media/{media}', [ArticleController::class, 'updateMedia'])->name('media.update');
});

