<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\DeliveryPerson;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function shopOrders(){
        $orders = Order::select('orders.*','users.name as user_name','users.email as user_email')
                ->when(request('key'),function($query){
                    $query->where('orders.order_code','like','%'.request('key').'%');

                })
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('orders.created_at','asc')
                ->paginate(3);

                $deliveryPeople = DeliveryPerson::all();
        return view('shop.userOrders.view',compact('orders','deliveryPeople'));


    }
    public function assignDeliveryPerson(Request $request,$orderId){
        // dd('Reached Controller', $request->all(), $orderId);
        $request->validate([
            'delivery_person_id' => 'required|exists:delivery_persons,id'
        ]);


        $order = Order::findOrFail($orderId);


        $order->delivery_person_id = $request->delivery_person_id;
        $order->save();

        return redirect()->back()->with('success','Delivery Person Assigned Successfully');
    }
    // public function assignDeliveryPerson(Request $request, $orderId){
    //     $order = Order::findOrFail($orderId);
    //     $order->delivery_person_id = $request->delivery_person_id;
    //     $order->save();
    //     return redirect()->back()->with('success', 'Delivery  Person Assigned Successfully');
    // }

    //order page
    public function list(){
        $orders =  Order::select('orders.*','users.name as user_name')
        ->when(request('key'),function($query){
          $query->where('orders.order_code','like','%'.request('key').'%');
        })
        ->leftJoin('users','users.id','orders.user_id')
        ->orderBy('orders.created_at','asc')
        ->paginate(3);
    return view('admin.order.list',compact('orders'));
 }


    public function ajaxStatus(Request $request){
        $request->status = $request->status == null ? "" : $request->status;
        $order  = Order::select('orders.*','users.name as user_name')
                  ->leftJoin('users','users.id','orders.user_id')
                  ->orderBy('orders.created_at','asc');

        if($request->status == null){
            $order = $order->get();
        }else{
            $order = $order->where('orders.status',$request->status)->get();
        }

        return response()->json($order,200);
        // logger($request->all());
        // Order::where('id',$request->id)->update(['status' => $request->status]);
        // return response()->json(['status' => 'true']);
    }


    public function ajaxChangeStatus(Request $request){
        Order::where('id',$request->orderId)->update([
            'status' => $request->status
        ]);
    }


    public function listInfo($orderCode){
        $order = Order::where('order_code',$orderCode)->first();
        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.name as product_name','products.image as product_image')
                    ->leftJoin('users','users.id','order_lists.user_id')
                    ->leftJoin('products','products.id','order_lists.product_id')
                    ->where('order_code',$orderCode)
                    ->get();
        $deliveryPeople = DeliveryPerson::all();
        return view('admin.order.productList',compact('orderList','order','deliveryPeople'));
    }
}
