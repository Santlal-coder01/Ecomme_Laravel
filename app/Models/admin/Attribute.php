<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Attribute extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
       'name' ,
       'name_key',
       'is_variant' ,
       'status'  
];




public function attributeValues()
{
    return $this->hasMany(AttributeValue::class);
}

}
