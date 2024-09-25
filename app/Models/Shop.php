<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable= [
        'name',
        'address',
        'phone',
        'user_id',
    ];

    public function deliveryPerson(){
        return $this->hasMany(DeliveryPerson::class,'shop_id');
    }
}
