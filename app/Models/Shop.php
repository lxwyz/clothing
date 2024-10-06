<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable= [
        'name', 'address', 'phone', 'email', 'password','gender','image', 'user_id',
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Each shop can have many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
