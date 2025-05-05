<?php

namespace App\Http\Controllers;

use App\Models\FlaggedComment;
use Illuminate\Http\Request;

class FlaggedCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('flagged_comments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(FlaggedComment $flaggedComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FlaggedComment $flaggedComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FlaggedComment $flaggedComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlaggedComment $flaggedComment)
    {
        //
    }
}
