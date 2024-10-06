<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
//
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    //direct login  page
    public function loginPage(){
        return view('login');
    }

    //direct register page
    public function registerPage(){
        return view('register');
    }

    //direct dashboard
    public function dashboard(){
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('category#list');
            }else if(Auth::user()->role == 'shop_admin'){
                return redirect()->route('products#list');
            }else if(Auth::user()->role == 'delivery_person'){
                return redirect()->route('deliveryPerson#viewOrders');
            }
            else {
                return redirect()->route('user#home');
            }
        }

        return redirect()->route('auth#loginPage');
    }
    }


