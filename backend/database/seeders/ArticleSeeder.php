<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = config('bsvdb.articles');
        foreach ($articles as $article) {
            $newArticle = new Article();
            $newArticle->title = $article['title'];
            $newArticle->subtitle = $article['subtitle'];
            $newArticle->article = $article['article'];
            $newArticle->user_id = 1;
            $newArticle->save();
        }
    }
}
