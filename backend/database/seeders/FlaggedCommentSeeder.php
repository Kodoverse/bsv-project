<?php

namespace Database\Seeders;

use App\Models\FlaggedComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlaggedCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flag_comments = config('bsvdb.flagged_comments');
        foreach ($flag_comments as $flag_comment) {
            $newComment = new FlaggedComment();
            $newComment->reason = $flag_comment['reason'];
            $newComment->user_id = $flag_comment['user_id'];
            $newComment->comment_id = $flag_comment['comment_id'];
            $newComment->save();
        }
    }
}
