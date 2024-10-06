<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{

    public function registerPage(){
        return view('shop.account.register');
    }


    public function store(Request $request){
        // Validate the request input
        $this->shopValidationCheck($request, 'create');

        // Prepare the data for creating the user and shop
        $data = $this->requestShopInfo($request);

        // Handle file upload for the shop's image
        $fileName = uniqid().$request->file('shopImage')->getClientOriginalName();
        $request->file('shopImage')->storeAs('public', $fileName);
        $data['image'] = $fileName;

        // Create the user associated with the shop
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address'=> $data['address'],
            'password' => Hash::make($data['password']),
            'role' => 'shop_admin',
            'gender' => $data['gender'],
            'image' => $data['image'] ?? null, // Use null if no image was uploaded
        ]);

        // Create the shop and associate it with the user
        Shop::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            'image' => $data['image'] ?? null,
            'user_id' => $user->id, // Link to the created user
        ]);

        // Redirect with a success message
        return redirect()->route('products#list')->with('success', 'Shop registered successfully!');
    }

    private function shopValidationCheck($request, $action) {
        // Validation rules for shop registration
        $validationRules = [
            'shopName' => 'required|string|max:255',
            'shopEmail' => 'required|email|unique:shops,email', // Ensure email is unique in the shops table
            'shopPhone' => 'required|string|max:20',
            'shopAddress' => 'required|string',
            'shopPassword' => 'required|string|min:6|max:8|confirmed', // Add password confirmation
            'shopGender' => 'required|in:male,female',
            'shopImage' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Image is required
        ];

        // Modify validation rules for update (if needed in future)
        if ($action == "update") {
            $validationRules['shopEmail'] = 'required|email|unique:shops,email,' . $request->id; // Allow existing email
            $validationRules['shopImage'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048'; // Image is optional for update
        }

        // Validate the request based on the defined rules
        Validator::make($request->all(), $validationRules)->validate();
    }

    // Prepare shop info from the request
    private function requestShopInfo($request) {
        return [
            'name' => $request->shopName,
            'email' => $request->shopEmail,
            'phone' => $request->shopPhone,
            'image' => $request->shopImage,
            'address' => $request->shopAddress,
            'gender' => $request->shopGender,
            'password' => $request->shopPassword,
        ];
    }




}
