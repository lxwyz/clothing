<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
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
            // Check the role of the authenticated user
            if (Auth::user()->role == 'admin') {
                return redirect()->route('category#list'); // Adjust this route as needed
            }
            else {
                return redirect()->route('user#home'); // Adjust this route as needed
            }
        }

        return redirect()->route('auth#loginPage');
    }


}
