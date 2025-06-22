<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlaggedComment;
use Illuminate\Http\Request;
use App\Models\Comment;

class ApiCommentController extends Controller
{
    public function flagComment(Request $request)
    {

           
        $comment = Comment::find($request->comment_id);
        if(!$comment){
            return response()->json(['message' => 'Comment not found'], 404);
        };
        $comment->is_flagged = true;
        $comment->save();
        FlaggedComment::create([
            'comment_id' => $request->comment_id,
            'reason' => $request->reason,
            'user_id' => auth()->user()->id

        ]);
        
    }
}
