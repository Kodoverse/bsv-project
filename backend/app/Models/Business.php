<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name',
        'address',
        'business_category_id',
        'partner_id',
        'description',
        'logo',
        'website',
        'hours',
        'email',
    ];

    protected $casts = [
        'business_hours' => 'json',
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'business_id');
    }
}
