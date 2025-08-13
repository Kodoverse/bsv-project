<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlaggedComment;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Resources\CommentResource;

class ApiCommentController extends Controller
{
    public function addComment(Request $request)
    {
        Comment::create([
            'comment' => $request->comment,
            'article_id' => $request->article_id,
            'like' => 0,
            'is_flagged' => 0,
            'user_id' => auth()->user()->id
        ]);
    }

    public function getByArticle($id)
    {
        $comments = Comment::with(['user.info', 'flags'])
            ->where('article_id', $id)
            ->latest()
            ->get();

        $currentUser = auth()->check() ? auth()->user()->load('info') : null;

        return response()->json([
            'result' => [
                'comments' => CommentResource::collection($comments)
            ],
            'current_user' => $currentUser
        ]);

    }
    public function flagComment(Request $request)
    {

        $user = auth()->user();
        $comment = Comment::find($request->comment_id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        ;

        $alreadyFlagged = FlaggedComment::where('comment_id', $comment->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyFlagged) {
            return response()->json(['message' => 'Hai già segnalato questo commento.'], 403);
        }

        FlaggedComment::create([
            'comment_id' => $request->comment_id,
            'reason' => $request->reason,
            'user_id' => auth()->user()->id

        ]);
        $flagCount = FlaggedComment::where('comment_id', $comment->id)->count();
        if ($comment->is_flagged) {
            $comment->is_flagged = true;
        }
        // if($flagCount >= 3){

        // }
        $comment->save();

        return response()->json(['message' => 'Segnalazione inviata con successo']);
    }

   
}
