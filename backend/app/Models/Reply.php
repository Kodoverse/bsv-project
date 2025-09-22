<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'user_id',
        'comment_id',
        'reply',
    ];

      protected $casts = [
        'created_at' => 'datetime:c',
        'updated_at' => 'datetime:c',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }


}