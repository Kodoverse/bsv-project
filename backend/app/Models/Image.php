<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['name', 'alt', 'link'];

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function page_section() {
        return $this->belongsTo(PageSection::class);
    }
}
