<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReport;
use App\Models\User;
use Illuminate\Http\Request;

class CommentReportController extends Controller
{
    /**
     * Display a listing of comment reports.
     */
    public function index()
    {
        $reports = CommentReport::with(['user', 'comment.user', 'comment.article'])
            ->orderBy('status', 'asc') // show pending first
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.comment_reports.index', compact('reports'));
    }

    /**
     * Mark a report as resolved.
     */
    public function resolve(CommentReport $report)
    {
        $report->update(['status' => 'resolved']);

        return back()->with('success', 'Laporan berhasil ditandai sebagai selesai.');
    }

    /**
     * Delete the reported comment.
     */
    public function deleteComment(Comment $comment)
    {
        // Deleting the comment will automatically cascade-delete associated reports in DB
        $comment->delete();

        return back()->with('success', 'Komentar yang dilaporkan berhasil dihapus.');
    }

    /**
     * Block the user who posted the comment.
     */
    public function blockUser(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Tidak dapat memblokir akun Superadmin.');
        }

        $user->update(['is_blocked' => true]);

        return back()->with('success', "User {$user->name} berhasil diblokir.");
    }
}
