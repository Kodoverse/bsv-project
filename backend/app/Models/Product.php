<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'partner_id',
        'name',
        'description',
        'image_url',
        'points_price',
        'cash_equivalent',
        'stock_quantity',
        'is_available',
        'category',
        'metadata',
        'category_id'
    ];

    protected $casts = [
        'points_price' => 'integer',
        'cash_equivalent' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_available' => 'boolean',
        'metadata' => 'json'
    ];

    /**
     * Get the partner who owns this product
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    /**
     * Get all purchases for this product
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Check if product is in stock
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Check if product can be purchased
     */
    public function canBePurchased(): bool
    {
        return $this->is_available && ($this->stock_quantity > 0 || $this->stock_quantity === -1); // -1 means unlimited stock
    }

    /**
     * Decrease stock quantity
     */
    public function decreaseStock(int $quantity = 1): bool
    {
        if ($this->stock_quantity === -1) {
            return true; // Unlimited stock
        }

        if ($this->stock_quantity >= $quantity) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }

        return false;
    }

    /**
     * Increase stock quantity
     */
    public function increaseStock(int $quantity = 1): void
    {
        if ($this->stock_quantity !== -1) {
            $this->increment('stock_quantity', $quantity);
        }
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->points_price) . ' points';
    }

    /**
     * Get stock status
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity === -1) {
            return 'Unlimited';
        }
        
        if ($this->stock_quantity === 0) {
            return 'Out of Stock';
        }
        
        if ($this->stock_quantity <= 5) {
            return 'Low Stock';
        }
        
        return 'In Stock';
    }

    /**
     * Scope for available products
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                    ->where(function($q) {
                        $q->where('stock_quantity', '>', 0)
                          ->orWhere('stock_quantity', -1);
                    });
    }

    /**
     * Scope for partner products
     */
    public function scopeForPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

      public function category()
    {
        return $this->belongsTo(Category::class);
    }
}