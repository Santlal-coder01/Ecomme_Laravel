<?php

namespace App\Models\e_store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\admin\Product;
use App\Models\e_store\OrderItem;
use App\Models\e_store\OrderAddress;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_increment_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'address_2',
        'city',
        'state',
        'country',
        'pincode',
        'coupon',
        'coupon_discount',
        'total',
        'payment_method',
        'shipping_method',
        'shipping_cost',
        'sub_total',
    ];


public function items()
{
    return $this->hasMany(OrderItem::class); 
}

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->hasmany(Product::class,'id'); 
    }
}
