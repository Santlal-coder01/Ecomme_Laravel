<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use factory,HashApiTokens;
    protected $table = 'users';
}
