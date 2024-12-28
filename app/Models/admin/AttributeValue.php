<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;


class AttributeValue extends Model implements HasMedia
{   
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
        'attribute_id',
        'name',
        'status'
   
];
public function attribute(){
    return $this->belongsTo(Attribute::class);
}
}
