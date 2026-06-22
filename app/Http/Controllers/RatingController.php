<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Upsert user rating for an article.
     */
    public function upsert(Request $request, Article $article)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            [
                'article_id' => $article->id,
                'user_id' => Auth::id(),
            ],
            [
                'rating' => $validated['rating'],
            ]
        );

        // Access the average rating attribute
        $averageRating = $article->average_rating;
        $totalRatings = $article->ratings()->count();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Rating Anda berhasil disimpan!',
                'average_rating' => $averageRating,
                'total_ratings' => $totalRatings,
            ]);
        }

        return back()->with('success', 'Rating berhasil disimpan!');
    }
}
