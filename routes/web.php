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
Route::middleware(['auth', 'blocked'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Superadmin Routes
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('users', UserController::class);
        
        // Moderation Routes
        Route::resource('allowed-words', \App\Http\Controllers\Admin\AllowedWordController::class)->except(['show', 'edit', 'update']);
        Route::get('reports', [\App\Http\Controllers\Admin\CommentReportController::class, 'index'])->name('reports.index');
        Route::post('reports/{report}/resolve', [\App\Http\Controllers\Admin\CommentReportController::class, 'resolve'])->name('reports.resolve');
        Route::delete('reports/comments/{comment}', [\App\Http\Controllers\Admin\CommentReportController::class, 'deleteComment'])->name('reports.comments.destroy');
        Route::post('reports/users/{user}/block', [\App\Http\Controllers\Admin\CommentReportController::class, 'blockUser'])->name('reports.users.block');
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

    // Comments & Ratings
    Route::post('articles/{article}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('articles.comments.store');
    Route::delete('comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('articles/{article}/ratings', [\App\Http\Controllers\RatingController::class, 'upsert'])->name('articles.ratings.upsert');
    Route::post('comments/{comment}/report', [\App\Http\Controllers\CommentReportController::class, 'report'])->name('comments.report');
});

