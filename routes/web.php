<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['admin_auth'])->group(function(){
    Route::redirect('/','loginPage');

    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class,'registerPage'])->name('auth#registerPage');

});






Route::middleware(['auth'])->group(function () {

    //dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');




    //admin
    Route::middleware(['admin_auth'])->group(function(){

    //category
    Route::prefix('category')->group(function(){
        Route::get('list',[CategoryController::class,'list'])->name('category#list');
        Route::get('create/page',[CategoryController::class,'createPage'])->name('category#createPage');
        Route::post('create',[CategoryController::class,'create'])->name('category#create');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
        Route::get('edit/{id}', [CategoryController::class,'edit'])->name('category#edit');
        Route::post('update/{id}',[CategoryController::class,'update'])->name('category#update');
    });

    //admin account
    Route::prefix('admin')->group(function(){
        Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
        Route::post('change/password', [AdminController::Class,'changePassword'])->name('admin#changePassword');
        Route::get('list',[AdminController::class,'list'])->name('admin#list');
        Route::get('delete',[AdminController::class,'delete'])->name('admin#delete');
        Route::get('changeRole/{id}',[AdminController::class,'changeRole'])->name('admin#changeRole');
        Route::post('change/role/{id}',[AdminController::class,'change'])->name('admin#change');
    });
      //Products' Routes
      Route::prefix('products')->group(function(){
        Route::get('list',[ProductController::class,'list'])->name('products#list');
        Route::get('create/page',[ProductController::class,'createPage'])->name('products#createPage');
        Route::post('create',[ProductController::class,'create'])->name('products#create');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('products#delete');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('products#edit');
        Route::get('updatePage/{id}',[ProductController::class,'updatePage'])->name('products#updatePage');
        Route::post('update/{id}',[ProductController::class, 'update'])->name('products#update');
    });

    Route::prefix('user')->group(function(){
        Route::get('userList',[UserController::class,'userList'])->name('admin#userList');
        Route::get('ajax/status/change',[UserController::class,'ajaxUserChangeStatus'])->name('admin#ajaxUserChangeStatus');
    });

    Route::prefix('order')->group(function(){
        Route::get('list',[OrderController::class,'list'])->name('order#list');
        Route::get('ajax/status',[OrderController::class,'ajaxStatus'])->name('order#ajaxStatus');
        Route::get('ajax/status/change',[OrderController::class,'ajaxChangeStatus'])->name('order#ajaxStatusChange');
        Route::get('listInfo/{ordercode}',[OrderController::class,'listInfo'])->name('order#listInfo');

    });

    //profile

    Route::get('details',[AdminController::class,'details'])->name('admin#details');
    Route::get('edit',[AdminController::class,'edit'])->name('admin#edit');
    Route::post('update{id}',[AdminController::class,'update'])->name('admin#update');


    // Route::prefix('shop')->group(function(){
    //     Route::get('list',[AdminController::class,'shopList'])->name('shop#list');
    // });
});



    //shop admin

    // Route::group(['prefix'=>'shop','middleware'=>'shop_auth'],function(){

    // });


    //user home.
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function() {
        Route::get('home', [UserController::class, 'home'])->name('user#home');
        Route::get('/filter/{id}',[UserController::class,'filter'])->name("user#filter");
        Route::get('details/{id}',[UserController::class,'detailsPage'])->name('user#detailsPage');
        Route::get('/history',[UserController::class,'historyPage'])->name('user#historyPage');


        Route::prefix('password')->group(function(){
            Route::get('change',[UserController::class,'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('change',[UserController::class,'changePassword'])->name('user#changePassword');

        });


        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user#cartList');
            // Route::get('delete/{id}',[UserController::class,'cartDelete'])->name('user#cartDelete');
            // Route::post('update/{id}',[UserController::class,'cartUpdate'])->name('user#cartUpdate');
            // Route::post('checkout',[UserController::class,'checkout'])->name('user#checkout');
        });

        Route::prefix('account')->group(function(){
            Route::get('change',[UserController::class,'accountChangePage'])->name('user#accountChangePage');
            Route::post('change/{id}',[UserController::class,'accountChange'])->name('user#accountChange');
        });

       Route::prefix('ajax')->group(function(){
            Route::get('product/list',[AjaxController::class,'productList'])->name('ajax#productList');
            Route::post('cart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
            Route::get('increase/viewCount',[AjaxController::class,'increaseViewCount'])->name('ajax#increaseViewCount');
            Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
            Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
            Route::get('remove/cart',[AjaxController::class,'removeCart'])->name('ajax#removeCart');
        });
       });


    });






