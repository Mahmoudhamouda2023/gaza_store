<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest('id')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $category = new Category();
        return view('admin.categories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'image' => 'required',
        ]);

        $data = $request->except('_token', 'image');
        $category = Category::create($data);

        $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $img_name);
        $category->image()->create([
            'path' => $img_name
        ]);



        flash()->success('Category added successfully');
        return redirect()->route('admin.categories.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('_token', 'image');

        if ($request->hasFile('image')) {
            File::delete(public_path('images/' . $category->image?->path));
            $category->image()->delete();

            $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $img_name);
            $category->image()->create([
                'path' => $img_name
            ]);
        }

        $category->update($data);



        flash()->info('Category updated successfully');
        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete(); // الصورة تتحذف تلقائياً من الـ Model Event
        flash()->info('Category deleted successfully');
        return redirect()->route('admin.categories.index');
    }
}
