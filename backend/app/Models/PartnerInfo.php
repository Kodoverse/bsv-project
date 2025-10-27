<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerInfo extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'lastname',
        'contact_phone',
        'redemption_rules',
        'min_points_per_redemption',
        'max_points_per_redemption',
        'is_active',
    ];

    protected $casts = [
        'min_points_per_redemption' => 'integer',
        'max_points_per_redemption' => 'integer',
        'is_active' => 'boolean',
        'business_hours' => 'json',
    ];

    /**
     * Get the user that owns this partner info
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'partner_id', 'user_id');
    }

    public function scopeForPartner($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('user_role', 'partner');
        });
    }

}
