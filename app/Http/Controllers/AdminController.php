<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Shop;
use App\Models\DeliveryPerson;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Storage;

class AdminController extends Controller
{
    public function deleteDelivery(){
        $deliveryPerson = DeliveryPerson::findOrFail($id);
        $deliveryPerson->delete();
        return redirect()->route('admin.delivery.deliveryList')->with('deleteSuccess', 'Shop deleted successfully.');
    }
    public function viewDeliveryPerson($id){
        $deliveryPerson = DeliveryPerson::findOrFail($id);
        return view('admin.delivery.viewDelivery',compact('deliveryPerson'));
    }
    public function deliveryPersonList(){
        $deliveryPersons = DeliveryPerson::when(request('key'),function($query){
                         $query->where('name','like','%'.request('key').'%')
                               ->orWhere('email','like','%'.request('key').'%')
                               ->orWhere('phone','like','%'.request('key').'%');
        })->paginate(3);

        return view('admin.delivery.deliveryList',compact('deliveryPersons'));
    }

    public function shopList()
    {
        $shops = Shop::when(request('key'), function($query) {
                $query->where('name', 'like', '%' . request('key') . '%')
                      ->orWhere('email', 'like', '%' . request('key') . '%')
                      ->orWhere('phone', 'like', '%' . request('key') . '%');
            })->paginate(3);

        return view('admin.shop.shopList', compact('shops'));
    }

    public function show($id){
        $shop =Shop::findOrFail($id);
        return view('admin.shop.show',compact('shop'));
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return redirect()->route('admin.shops.index')->with('deleteSuccess', 'Shop deleted successfully.');
    }

    public function list(){
        $admins = User::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%')
                  ->orWhere('email','like','%'.request('key').'%')
                  ->orWhere('gender','like','%'.request('key').'%')
                  ->orWhere('phone','like','%'.request('key').'%')
                  ->orWhere('address','like','%'.request('key').'%');
        })->where('role','admin')->paginate(3);
        $admins->appends(request()->all());
        return view('admin.account.list',compact('admins'));
    }

     //direct change password page
     public function changePasswordPage(){
        return view('admin.account.change');
    }

    //edit profile page
    public function edit(){
        return view('admin.account.edit');
    }

    //update profile
    public function update($id,Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,png,jpeg'
        ]);
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
        return redirect()->route('admin#details')->with('updateSuccess','Profile updated successfully.');
    }

    //delete admin account
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with('deleteSuccess','Profile deleted successfully.');
    }

    // request user data
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
    //change admin role
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('account'));
    }

    // change admin role
    public function change($id,Request $request){
        $data = $this->reqeustUserDate($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list')->with('updateSuccess','Role changed successfully.');
    }
    private function reqeustUserDate($request){
        return [
            'role' => $request->role
        ];
    }
    //change password
    public function changePassword(Request $request){
        /*
            1. all fields must be filled.
            2.new password and confirm password must be greater than 6.
            3.new password and confirm password must be same.
            4.client old password must be same with db password.
            5.password change.
        */
        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashPassword = $user->password;

        if(Hash::check($request->oldPassword,$dbHashPassword)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);
            return back();
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

    public function details(){
        return view('admin.account.details');
    }
}
