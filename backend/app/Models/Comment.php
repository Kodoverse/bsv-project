<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'like', 'is_flagged', 'predefinite_comment', 'article_id', 'user_id'];

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function flags() {
        return $this->hasMany(FlaggedComment::class);
    }
}
