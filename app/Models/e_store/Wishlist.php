<?php

namespace App\Models\e_store;
use App\Models\User;
use App\Models\admin\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }



//     public function wishlist()
// {
//     return $this->belongsToMany(Product::class, 'wishlist', 'user_id', 'product_id');
// }
}