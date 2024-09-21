<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Support\Facades\Auth;
class AjaxController extends Controller
{
    public function productList(Request $request){
        if($request->status == 'desc'){
            $products = Product::orderBy('created_at','desc')->get();
        }else{
            $products = Product::orderBy('created_at','asc')->get();
        }
        return response()->json($products,200);
    }



    public function order(Request $request){
        foreach($request->orders as $item){
            // logger($item);
            $total = 0;
            $data = OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'Qty' => $item['Qty'],
                'total_amount' => $item['total_amount'],
                'order_code' => $item['order_code'],
            ]);

            $total += $data->total_amount;
        }
        Cart::where('user_id',Auth::user()->id)->delete();
        Order::create([
            'user_id' =>Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total
        ]);
        $response = [
           'message' => 'Order placed successfully.',
           'status' => 'true',
        ];
        return response()->json($response,200);
    }


    public function addToCart(Request $request){
        $data = $this->getOrderData($request);
        Cart::create($data);
        $response = [
            'message' => 'Product added to cart successfully.',
            'status' => 'success',
        ];
        return response()->json($response,200);
    }
    private function getOrderData($request){
        return [
            'user_id' =>$request->userId,
            'product_id' =>$request->productId,
            'Qty' =>$request->count,
        ];
    }

    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
        return response()->json(['status' => 'true']);
    }

    public function removeCart(Request $request){
       Cart::where('user_id',Auth::user()->id)->where('product_id',$request->product_id)->delete();
       return response()->json(['status' => 'true']);
    }


    public function increaseViewCount(Request $request)
    {
        // Find the product and increment its view count in one step
        $product = Product::where('id', $request->productId)->first();

        if ($product) {
            $product->view_count += 1;
            $product->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'View count increased!',
                'viewCount' => $product->view_count
            ]);
        }

        // Return an error response if product not found
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found!'
        ], 404);
    }
}
