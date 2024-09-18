<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //order page

    public function list(){
        $orders =  Order::select('orders.*','users.name as user_name')
                          ->when(request('key'),function($query){
                            $query->where('orders.order_code','like','%'.request('key').'%');
                          })
                          ->leftJoin('users','users.id','orders.user_id')
                          ->orderBy('orders.created_at','asc')
                          ->paginate(3);
        // dd($orders->toArray());
        return view('admin.order.list',compact('orders'));
    }

}
