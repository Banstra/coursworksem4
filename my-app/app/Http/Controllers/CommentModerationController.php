<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentModerationController extends Controller
{
    /**
     * Список комментариев, ожидающих модерации
     */
    public function index()
    {
        $this->authorize('moderate', Comment::class);

        $pendingComments = Comment::with(['article', 'user'])
            ->pending()
            ->latest()
            ->paginate(10);

        return view('comments.moderation.index', compact('pendingComments'));
    }

    /**
     * Одобрить комментарий
     */
    public function approve(Request $request, Comment $comment)
    {
        $this->authorize('moderate', $comment);

        $comment->update([
            'is_approved' => true,
            'moderated_at' => now(),
            'moderated_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', '✅ Комментарий одобрен');
    }

    /**
     * Отклонить комментарий
     */
    public function reject(Request $request, Comment $comment)
    {
        $this->authorize('moderate', $comment);

        $comment->update([
            'is_approved' => false,
            'moderated_at' => now(),
            'moderated_by' => Auth::id(),
        ]);

        // Опционально: удаляем отклонённый комментарий
        // $comment->delete();

        return redirect()->back()->with('success', '❌ Комментарий отклонён');
    }
}
