<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use Storage;

class ProductController extends Controller
{
    //product list page
    public function list(){
       $products = Product::select('products.*','categories.name as category_name')
                    ->when(request('key'),function($query){
                    $query->where('products.name','like','%'.request('key').'%');
                    })
                    ->leftJoin('categories','products.category_id','categories.id')
                    ->orderBy('products.created_at','asc')
                    ->paginate(3);
        // dd($products->toArray());
       $products->appends(request()->all());
       return view('shop.products.productList',compact('products'));
    }
    public function view(){
        $products = Product::select('products.*','categories.name as category_name')
                     ->when(request('key'),function($query){
                     $query->where('products.name','like','%'.request('key').'%');
                     })
                     ->leftJoin('categories','products.category_id','categories.id')
                     ->orderBy('products.created_at','asc')
                     ->paginate(3);
         // dd($products->toArray());
        $products->appends(request()->all());
        return view('admin.products.productList',compact('products'));
     }


    // direct create product page
    public function createPage(){
        $shops = Shop::all();
        $categories = Category::select('id','name')->get();

        return view('shop.products.createProduct',compact('categories','shops'));
    }

    //delete product

    public function delete($id){
        $product =Product::where('id',$id)->delete();
        return redirect()->route('products#list')->with('deleteSuccess','Product deleted successfully.');
    }




    //product details
    public function edit($id){
        $products = Product::where('id',$id)->first();

        return view('shop.products.edit',compact('products'));
    }


    //update page
    public function updatePage($id){
        $products = Product::where('id',$id)->first();
        $categories = Category::select('id','name')->get();
        return view('shop.products.update',compact('products','categories'));
    }

    //products update
    public function update($id,Request $request){
        $this->productValidationCheck($request, 'update');

    // Get product data from request
    $data = $this->requestProductInfo($request);

    // Handle image upload
    if($request->hasFile('productImage')){
        $oldImage = Product::where('id', $id)->first()->image;

        // Delete the old image if it exists
        if($oldImage != null){
            Storage::delete('public/'.$oldImage);
        }

        // Upload new image
        $fileName = uniqid().'_'.$request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public', $fileName);
        $data['image'] = $fileName;
    }

    // Update product
    Product::where('id', $id)->update($data);

    // Redirect back to the product list
    return redirect()->route('products#list')->with('updateSuccess', 'Product updated successfully.');
    }


    // product create
    public function create(Request $request){
       $this->productValidationCheck($request,'create');

       $data = $this->requestProductInfo($request);
       $data['shop_id'] = $request->shop_id;


        $fileName = uniqid().$request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public',$fileName);
        $data['image'] = $fileName;


        Product::create($data);
        // dd($data->toArray());

        return redirect()->route('products#list')->with('createSuccess','Product created successfully.');
    }

    private function productValidationCheck($request,$action){

        $validationRules = [
            'productName' => 'required|unique:products,name'.$request->product_id,
            'productCategory' => 'required',
            'productDescription' => 'required',
            'productPrice' => 'required|numeric',
            'shop_id' => 'required|exists:shops,id',

        ];

        $validationRules['productImage'] = $action == "create" ?  'required|mimes:jpg,jpeg,png' : 'mimes:jpg,jpeg,png';

        Validator::make($request->all(),$validationRules)->validate();


    }

    //request product info
    private function requestProductInfo($request){
        return[
            'name' =>$request->productName,
            'category_id' => $request->productCategory,
            'description' => $request->productDescription,
            'price' => $request->productPrice,
            'shop_id'=>$request->shop_id
        ];
    }

}
