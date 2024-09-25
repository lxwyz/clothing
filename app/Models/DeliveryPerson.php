<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Users;
use App\Models\Order;
class DeliveryPerson extends Model
{
    use HasFactory;
    protected $table= 'delivery_persons';

    protected $fillable =[
        'name',
        'email',
        'address',
        'gender',
        'phone',
        'image',
        'shop_id',
        'user_id',
        'password',
    ];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders(){
        return $this->hasMany(Order::class,'delivery_person_id');
    }
}
