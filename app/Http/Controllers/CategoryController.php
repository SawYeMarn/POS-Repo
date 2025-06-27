<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //direct Categroy List Page
    public function list() {
        $categories = Category::orderBy('created_at', 'desc')->paginate(5);
    return view('admin.category.list', compact('categories'));

    }

    public function create(Request $request) {
    $this->validateCategory($request);



        // Create a new category
        Category::create([
            'name'=>$request->categoryName
        ]);
     Alert::success('Success Title', 'Category created successfully');
        return back();
    }

    //categroy validation
    private function validateCategory($request){
        $request->validate([
        'categoryName'=> 'required|min:3|max:20|unique:categories,name,'.$request->id,
        ],[
            'categoryName.required' => 'Please enter a category name',
            'categoryName.min' => 'Category name must be at least 3 characters',
            'categoryName.max' => 'Category name must not exceed 20 characters',
            'categoryName.unique' => 'This category name already exists',
        ]);
    }

    public function delete($id) {
        // Find the category by ID
       Category::where('id', $id)->delete();
        // Redirect back with success message
        Alert::success('Success Title', 'Category deleted successfully');
        return back();
    }

    public function edit($id){
        $category=Category::where('id', $id)->first();
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request, $id){
        $this->validateCategory($request);

        Category::where('id', $id)->update([
            'name' => $request->categoryName
        ]);
        Alert::success('Success Title', 'Category updated successfully');
        return redirect()->route('category#list');
    }
}
