<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['title'];

    public function page_sections() {
        return $this->hasMany(PageSection::class);
    }
}
