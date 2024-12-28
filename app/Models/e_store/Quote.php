<?php

namespace App\Models\e_store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\a\Product;

class Quote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'quotes';
    protected $fillable = [
        'cart_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'subtotal',
        'coupon',
        'coupon_discount',
        'total',
    ];
    public function items()
    {
        return $this->hasMany(QuoteItem::class, 'quote_id');
    }



    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id', 'id'); // Adjust 'product_id' if your foreign key is named differently
    // }
}