<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Page extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $fillable = [
            'name',
            'status',
            'show_in_menu',
            'show_in_footer',
            'description', 
            'url_key',
            'meta_tag', 
            'meta_title', 
            'meta_description'      
    ];

    
}
