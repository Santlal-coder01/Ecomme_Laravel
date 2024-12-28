<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enquiry extends Model
{
   use HasFactory;
   protected $fillable = [
    'name',
    'email',
    'contact',
    'message',
   ];

}
