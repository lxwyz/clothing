<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;


class CategoryController extends Controller
{

    //direct list of category
    public function list(){
        $categories = Category::when(request('key'),function($query){
                    $query->where('name','like','%'.request('key').'%');
        })
                     ->orderBy('id')->paginate(4);
        $categories->appends(request()->all());
        return view('admin.category.list',compact('categories'));
    }


    //direct create category page
    public function createPage(){
        return view('admin.category.create');
    }


    public function create(Request $request){
        $this->categoryValidatorCheck($request);
        $data =$this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list')->with('createSuccess','Category created successfully.');

    }

    //delete category
    public function delete($id){
        Category::where('id',$id)->delete();
        return redirect()->route('category#list')->with('deleteSuccess','Category deleted successfully.');
    }

    //edit category
    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }

    //update category
    public function update($id,Request $request){
        $this->categoryValidatorCheck($request);
        Category::where('id',$id)->update($this->requestCategoryData($request));
        return redirect()->route('category#list')->with('updateSuccess','Category updated successfully.');
    }

    //category validation check.
    private function categoryValidatorCheck($request){
        Validator::make($request->all(),[
            'categoryName' => 'required|unique:categories,name'
        ])->validate() ;
    }


    // request category data
    private function requestCategoryData($request){
        return [
            'name' => $request->categoryName
        ];
    }

    //
}
