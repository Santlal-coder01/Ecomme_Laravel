<?php

namespace App\Models\e_store;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\e_store\Order;

class OrderAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
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
        'address_type',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}