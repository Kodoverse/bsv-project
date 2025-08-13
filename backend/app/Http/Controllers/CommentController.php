<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return view('comments.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return view('comments.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->comment = $request->comment;
        $comment->save();
        return response()->json(['message' => 'Commento modificato con successo']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Commento eliminato con successo']);
    }

    public function toggleLike(Request $request, $commentId)
    {
        $user = auth()->user(); // utente autenticato
        $comment = Comment::findOrFail($commentId);

        if ($comment->likers()->where('user_id', $user->id)->exists()) {
            // se il like esiste, lo rimuovo
            $comment->likers()->detach($user->id);
            $comment->decrement('like');
            $action = 'Like rimosso';
        } else {
            // altrimenti lo aggiungo
            $comment->likers()->attach($user->id);
            $comment->increment('like');
            $action = 'Like aggiunto';
        }

        $comment->refresh();

        // conto i like aggiornati
        $likeCount = $comment->likers()->count();

        return response()->json([
            'message' => $action,
            'like_count' => $likeCount
        ]);
    }

}
