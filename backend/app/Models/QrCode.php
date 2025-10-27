<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'purchase_id',
        'product_id',
        'code',
        'status',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}