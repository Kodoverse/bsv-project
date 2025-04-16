<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = config('bsvdb.comments');
        foreach ($comments as $comment) {
            $newComment = new Comment();
            $newComment->comment = $comment['comment'];
            $newComment->like = $comment['like'];
            $newComment->is_approved = $comment['is_approved'];
            $newComment->predefinite_comment = $comment['predefinite_comment'];
            $newComment->article_id = $comment['article_id'];
            $newComment->save();
        }
    }
}
