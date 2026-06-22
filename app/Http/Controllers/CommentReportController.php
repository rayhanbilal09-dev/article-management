<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReportController extends Controller
{
    /**
     * Report a comment.
     */
    public function report(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Check if user already reported this comment
        $exists = CommentReport::where('comment_id', $comment->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah melaporkan komentar ini.');
        }

        CommentReport::create([
            'comment_id' => $comment->id,
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Laporan Anda berhasil dikirim dan akan segera ditinjau oleh admin.');
    }
}
