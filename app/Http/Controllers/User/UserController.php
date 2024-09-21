<?php

namespace App\Http\Controllers\User;

use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //user chanege role
    public function ajaxUserChangeStatus(Request $request){
        User::where('id',$request->userId)->update([
            'role' => $request->role
        ]);
    }
    //user account

    public function userList(){
        $users = User::where('role','user')->paginate(5);
        return view('admin.user.list',compact('users'));
    }

    //order History Page
    public function historyPage(){
        $order = Order::where('user_id',Auth::user()->id)
                    ->orderBy('created_at','desc')
                    ->paginate(5);
        return view('user.main.history',compact('order'));
    }
    //home
    public function home(){
        $products = Product::orderBy('created_at', 'asc')->get();
        $categories = Category::get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('products','categories','cart','history'));
    }

    //filter category
    public function filter($categoryId){
        $products = Product::where('category_id', $categoryId)->orderBy('created_at', 'asc')->get();
        $categories = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('products','categories','cart','history'));
    }
    // products details
    public function detailsPage($id){
        $product = Product::where('id',$id)->first();

        $productsList = Product::get();
        return view('user.main.details',compact('product','productsList'));
    }


    public function changePasswordPage(){
        return view('user.account.change');
    }

    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as product_name','products.price as product_price')
                ->leftJoin('products','products.id','carts.product_id')
                ->where('user_id',Auth::user()->id)
                ->get();
                // dd($cartList->toArray());

        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->product_price * $c->Qty;
        }
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    public function changePassword(Request $request){
         /*
            1. all fields must be filled.
            2.new password and confirm password must be greater than 6.
            3.new password and confirm password must be same.
            4.client old password must be same with db password.
            5.password change.
        */
        $this->passwordValidationCheck($request);
        //password change logic
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashPassword = $user->password;

        if(Hash::check($request->oldPassword,$dbHashPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            Auth::logout();

            return back()->with(['changeSuccess'=>'Password changed Successfully']);
        }
        return back()->with(['notMatch'=> 'The password that you entered is incorrect. Try Again!']);



    }
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:12',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:newPassword',
        ])->validate();
    }


    public function accountChangePage(){
        return view('user.account.change');
    }

    public function accountChange($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasFile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImage  = $dbImage->image;

            if($dbImage!= null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid().$request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;

        }

        User::where('id',$id)->update($data);
        return back()->with('updateSuccess','Profile updated successfully.');
    }

    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }
    private function accountValidationCheck($request){
      Validator::make($request->all(),[
        'name' =>'required|string|max:255',
        'email' =>'required|string|email|max:255|unique:users,email,'.Auth::user()->id,
        'gender' =>'required',
        'phone' =>'required',
        'address' =>'required',
        'image' =>'mimes:jpg,png,jpeg|file'
      ])->validate();
    }
}
