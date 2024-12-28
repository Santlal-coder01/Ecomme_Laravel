<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
        'product_id',
        'attribute_id',
        'attributevalue_id',
    ];


    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attributevalue_id');
        }

        public function attribute()
        {
            return $this->belongsTo(Attribute::class);
}

}
