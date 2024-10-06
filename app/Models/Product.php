<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'product_id',
        'category_id',
        'name',
        'description',
        'image',
        'price',
        'view_count',
        'shop_id'
    ];

    public function shopAdmin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Each product can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
