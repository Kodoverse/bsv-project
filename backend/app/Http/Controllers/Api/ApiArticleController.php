<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ApiArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with([
            'user.info',
            'comments',
            'images',
            'tags',
        ])->paginate(5);

        return response([
            'success' => true,
            'result' => $articles,
        ]);
    }

    public function show($id)
    {
        $article = Article::with([
            'user.info',
            'comments.user.info',
            'comments',
            'images',
            'tags',
        ])->find($id);

        return response([
            'success' => true,
            'result' => $article,
            'current_user' => auth()->check() ? auth()->user()->load('info') : null
        ]);

    }
}
