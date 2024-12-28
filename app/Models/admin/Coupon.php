<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'coupon_code',
        'status',
        'valid_from',
        'valid_to',
        'discount_amount',
    ];
    
}
