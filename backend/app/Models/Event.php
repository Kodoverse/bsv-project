<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'created_by',
        'title',
        'description',
        'image_url',
        'starts_at',
        'ends_at',
        'status',
        'is_volunteer_event',
        'volunteer_points',
        'max_participants'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_volunteer_event' => 'boolean',
        'volunteer_points' => 'integer'
    ];

    /**
     * Get the category of this event
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }

    /**
     * Get the user who created this event
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the registrations for this event
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the points awarded for this event
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }

    /**
     * Get the registered users for this event
     */
    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
            ->withPivot('status', 'registered_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
            ->where('starts_at', '>', now());
    }

    /**
     * Scope a query to only include finished events
     */
    public function scopeFinished($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'finished')
                ->orWhere('ends_at', '<', now());
        });
    }
}
