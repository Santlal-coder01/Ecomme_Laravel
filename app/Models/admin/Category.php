<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
// use App\Models\admin\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
        'parent_category',
        'name',  
        'status',
        'show_in_menu',  
        'url_key',
        'meta_tag' ,
        'meta_title', 
        'meta_description' ,   
        'short_description',             
        'description'
   
];

public function products(): BelongsToMany
{
    return $this->belongsToMany(Product::class,'product_categories');
}


public function productss()
{
    return $this->hasMany(Product::class);
}


}
