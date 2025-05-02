<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'like', 'is_flagged', 'predefinite_comment', 'article_id'];

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function flagged_comment() {
        return $this->belongsTo(Comment::class);
    }
}
