<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $request->validated();
        $newArticle = new Article();
        $newArticle->fill($request->all());
        $newArticle->save();
        return redirect()->route('articles.show', $newArticle->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article = Article::with(['images', 'comments', 'tags'])->findOrFail($article->id);
        return view('articles.show', compact("article"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact("article"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $request->validated();
        $article->update($request->all());
        $article->save();
        return redirect()->route('articles.show', $article->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
