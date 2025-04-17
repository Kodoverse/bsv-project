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
            'comments' => function ($query) {
                $query->where('is_approved', true);
            },
            'images',
            'tags',
        ])->paginate(5);

        return response([
            'success' => true,
            'result' => $articles,
        ]);
    }
    
}
