<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;

class CategoriesController extends Controller
{

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
    }
    public function report(Request $request){
        $selected = $request->get('selected');
        $limit = $request->get('limit');
        if($selected == "all"){
            $limit = null;
            $selected == "desc";            
        }
        $categories = \App\Category::report($limit , $selected);
        $arrayCategories = [];
        foreach ($categories as $cat) {
            $category = \App\Category::findOrFail($cat->category_id);
            $category['countCategory'] = $cat->countCategory;
            $arrayCategories [] = $category; 
        }
        return response()->json($arrayCategories); 
    }
    public function indexData(){
         $categories=\App\Category::orderBy('name', 'asc')->get();
         return response()->json($categories);
    }
    public function store(CreateCategoryRequest $request){
        $category=new \App\Category();
        $category->name=$request->get('name');
        $category->description=$request->get('description');
        $category->save();
        return response()->json($category);
    }
    public function destroy($id)
    {
        $category=\App\Category::findOrFail($id);
        $category->delete();
        return "ok";
    }
    public function update(Request $request, $id)
    {
         $validatedData = $request->validate([
         'name'=>'required|max:255|string|unique:categories,name,'.$id,              
        'description'=>'max:255'
        ]);
       $category=\App\Category::findOrFail($id)->update($request->all());
       return response()->json($category);
    }
    public function show($id){
        abort(404);
    }
}
