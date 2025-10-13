<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCategory extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'slug',
        'color',
        'image'
    ];

    protected $appends = ['image_url'];

    /**
     * Get the full URL for the category image
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return asset('storage/' . $this->image);
    }

    /**
     * Get the events in this category
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(EventCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(EventCategory::class, 'parent_id');
    }

    public function isSubcategory()
    {
        return !is_null($this->parent_id);
    }
}
