<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'awarded_by',
        'points',
        'reason',
        'type',
        'partner_id',
        'redemption_reference'
    ];

    protected $casts = [
        'points' => 'integer'
    ];

    /**
     * Get the user who earned these points
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event these points were earned from
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the admin who awarded these points
     */
    public function awardedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'awarded_by');
    }

    /**
     * Get the partner who processed this redemption
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    /**
     * Check if this is a redemption transaction
     */
    public function isRedemption(): bool
    {
        return $this->type === 'redemption';
    }

    /**
     * Check if this is an award transaction
     */
    public function isAward(): bool
    {
        return $this->type === 'award';
    }
}
