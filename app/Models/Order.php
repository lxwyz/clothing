<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DeliveryPerson;

class Order extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'order_code',
        'total_price',
        'status',
        'delivery_person_id',
    ];
    public function deliveryPerson(){
        return $this->belongsTo(DeliveryPerson::class,'delivery_person_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
