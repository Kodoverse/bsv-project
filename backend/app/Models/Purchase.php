<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Purchase extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'partner_id',
        'quantity',
        'points_spent',
        'points_per_item',
        'status',
        'redemption_code',
        'notes',
        'confirmed_at',
        'completed_at'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'points_spent' => 'integer',
        'points_per_item' => 'integer',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    /**
     * Boot method to generate redemption code
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            if (empty($purchase->redemption_code)) {
                $purchase->redemption_code = static::generateRedemptionCode();
            }
        });
    }

    /**
     * Generate unique redemption code
     */
    public static function generateRedemptionCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::where('redemption_code', $code)->exists());

        return $code;
    }

    /**
     * Get the user who made the purchase
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was purchased
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the partner who sold the product
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    /**
     * Check if purchase is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if purchase is confirmed
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if purchase is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if purchase is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Confirm the purchase
     */
    public function confirm(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);
    }

    /**
     * Complete the purchase
     */
    public function complete(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    /**
     * Cancel the purchase
     */
    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled'
        ]);

        // Restore stock if product exists
        if ($this->product) {
            $this->product->increaseStock($this->quantity);
        }
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
            'confirmed' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
            'completed' => 'bg-green-500/20 text-green-400 border-green-500/30',
            'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
            default => 'bg-gray-500/20 text-gray-400 border-gray-500/30'
        };
    }

    /**
     * Get formatted status
     */
    public function getFormattedStatusAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    /**
     * Scope for pending purchases
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for confirmed purchases
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for completed purchases
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for partner purchases
     */
    public function scopeForPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    /**
     * Scope for user purchases
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}