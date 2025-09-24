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

    /**
     * Update event status based on current time
     */
    public function updateStatus(): void
    {
        $now = now();
        
        if ($this->ends_at < $now && $this->status === 'upcoming') {
            $this->update(['status' => 'finished']);
        } elseif ($this->starts_at <= $now && $this->ends_at > $now && $this->status === 'upcoming') {
            $this->update(['status' => 'ongoing']);
        }
    }

    /**
     * Update all events statuses automatically
     */
    public static function updateAllStatuses(): int
    {
        $updated = 0;
        
        // Update upcoming events that have ended
        $endedEvents = Event::where('status', 'upcoming')
            ->where('ends_at', '<', now())
            ->get();
            
        foreach ($endedEvents as $event) {
            $event->update(['status' => 'finished']);
            $updated++;
        }
        
        // Update upcoming events that are now ongoing
        $ongoingEvents = Event::where('status', 'upcoming')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>', now())
            ->get();
            
        foreach ($ongoingEvents as $event) {
            $event->update(['status' => 'ongoing']);
            $updated++;
        }
        
        // Update ongoing events that have ended
        $finishedOngoingEvents = Event::where('status', 'ongoing')
            ->where('ends_at', '<', now())
            ->get();
            
        foreach ($finishedOngoingEvents as $event) {
            $event->update(['status' => 'finished']);
            $updated++;
        }
        
        return $updated;
    }
}
