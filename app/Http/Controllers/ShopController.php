<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{

    public function registerPage(){
        return view('shop.account.register');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:shops',
            'password' => 'required|string|min:8|confirmed',

        ]);

        // Create a new shop record
        $shop = Shop::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash the password before storing it in the database
            'user_id' => Auth::id(), // Assuming you want to link the shop to the currently logged-in user
        ]);

        return redirect()->route('products#list')->with('createSuccess','Shop Registeration succeed.');
    }




}
