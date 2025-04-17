<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ApiArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('comments');

        $articles = $query->paginate(5);
        return response([
            'success' => true,
            'result' => $articles,
        ]);
    }
    
}
