<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['type', 'content', 'section_id'];

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }
}

