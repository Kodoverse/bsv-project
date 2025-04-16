<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'subtitle', 'article'];

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
