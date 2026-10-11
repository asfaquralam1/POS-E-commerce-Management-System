<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', 1)->get();
        return view('admin.category.manage_category', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.category.add_category', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:0,1',
        ]);

        $category = new Category();
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->description = $data['description'] ?? null;
        $category->parent_id = $data['parent_id'] ?? null;
        $category->status = $data['status'];
        $category->save();
       
        return redirect()->route('admin.category')->with('success', 'Category Added Successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        return view('admin.category.edit_category', compact('category','categories'));
    }

    public function update(Request $request, $id)
    {
      $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:0,1',
        ]);

        $category = Category::find($id);
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->description = $data['description'] ?? null;
        $category->parent_id = $data['parent_id'] ?? null;
        $category->status = $data['status'];
        $category->update();
        return redirect()->route('admin.category')->with('success', 'Category Updated Successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        Category::destroy($id);
        return redirect()->route('admin.category')->with('warning', 'Category Deleted');
    }

    public function status(Request $request, $status, $id)
    {
        $category = Category::find($id);
        $category->status = $status;
        $category->save();
        $request->session()->flash('message', 'Category Status updated');
        return redirect()->route('admin.category');
    }
}
