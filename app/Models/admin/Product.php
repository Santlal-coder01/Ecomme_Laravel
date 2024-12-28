<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use App\Models\admin\Category;



class Product extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
        'name',
        'status',
        'is_featured',
        'sku',
        'qty',
        'stock_status',
        'weight',
        'price',
        'special_price', 
        'special_price_from', 
        'special_price_to',  
        'short_description', 
        'description', 
        'related_product', 
        'url_key', 
        'meta_tag', 
        'meta_title', 
        'meta_description' 
   
];


// public function relatedProducts() {
//     return $this->belongsToMany(Product::class, 'products');
// }
public function productattribute()
    {
        return $this->hasMany(ProductAttribute::class);
    }


public function categories(): BelongsToMany
{
    return $this->belongsToMany(Category::class,'product_categories');
}


// public function subcategory()
// {
//     return $this->belongsTo(Category::class, 'parent_category');
// }

public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'id');
}











// *
// * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
// */
// public function categories(): BelongsToMany
// {
//    return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
// }

}
