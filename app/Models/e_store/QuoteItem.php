<?php

namespace App\Models\e_store;
use App\Models\admin\Product;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class QuoteItem extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'quote_items';
    protected $fillable = [
        'quote_id',
        'product_id',
        'name',
        'sku',
        'price',
        'qty',
        'row_total',
        'custom_option',
    ];
    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}