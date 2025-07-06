<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlaggedComment;
use Illuminate\Http\Request;
use App\Models\Comment;

class ApiCommentController extends Controller
{
    public function addComment(Request $request){
        Comment::create([
            'comment' => $request->comment,
            'article_id' => $request->article_id,
            'like' => 0,
            'is_flagged' => 0,
            'user_id' => auth()->user()->id
        ]);
    }
    public function flagComment(Request $request)
    {

        $user = auth()->user(); 
        $comment = Comment::find($request->comment_id);
        if(!$comment){
            return response()->json(['message' => 'Comment not found'], 404);
        };

        $alreadyFlagged = FlaggedComment::where('comment_id', $comment->id)
        ->where('user_id', $user->id)
        ->exists();

        if($alreadyFlagged){
            return response()->json(['message' => 'Hai già segnalato questo commento.'], 403);
        }

        $comment->is_flagged = true;
        $comment->save();
        FlaggedComment::create([
            'comment_id' => $request->comment_id,
            'reason' => $request->reason,
            'user_id' => auth()->user()->id

        ]);
        
    }
}
