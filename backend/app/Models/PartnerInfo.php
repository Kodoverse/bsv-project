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
        'is_active'
    ];

    protected $casts = [
        'min_points_per_redemption' => 'integer',
        'max_points_per_redemption' => 'integer',
        'is_active' => 'boolean',
        'business_hours' => 'json'
    ];

    /**
     * Get the user that owns this partner info
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
