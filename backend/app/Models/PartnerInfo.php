<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerInfo extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_address',
        'business_category',
        'business_description',
        'business_logo',
        'business_website',
        'business_hours',
        'business_email',
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
}
