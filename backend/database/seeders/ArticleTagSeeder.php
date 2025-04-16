<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articleTag = [
            [
                'article_id' => 1, 
                'tag_id' => 1
            ],
            
            [
                'article_id' => 1, 
                'tag_id' => 3
            ],
            [
                'article_id' => 2, 
                'tag_id' => 2
            ],
        ];

        foreach($articleTag as $articleTagBond){
            $article = Article::find($articleTagBond['article_id']);
            $tag = Tag::find($articleTagBond['tag_id']);
            if($article && $tag){
                $article->tags()->attach($tag->id);
            }
            else {
                echo "article and/or tag iDs doesn't exit";
            }
        }
    }
}
