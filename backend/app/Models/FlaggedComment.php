<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlaggedComment extends Model
{
    protected $fillable = ['reason', 'user_id', 'comment_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comment() {
        return $this->hasOne(FlaggedComment::class);
    }
}

