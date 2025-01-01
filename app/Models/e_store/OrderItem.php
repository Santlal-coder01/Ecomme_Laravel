<?php

namespace App\Models\e_store;
use App\Models\admin\Product;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'sku',
        'price',
        'qty',
        'row_total',
        'custom_option',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

}