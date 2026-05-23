<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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

        ActivityLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'created',
            'model' => 'Category',
            'model_id' => $category->id,
            'description' => 'Created category: ' . $category->name,
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
            if ($category->image) {
                File::delete(public_path('images/' . $category->image->path));
                $category->image()->delete();
            }

            $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $img_name);

            $category->image()->create([
                'path' => $img_name
            ]);
        }

        $category->update($data);

        ActivityLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'updated',
            'model' => 'Category',
            'model_id' => $category->id,
            'description' => 'Updated category: ' . $category->name,
        ]);

        flash()->info('Category updated successfully');

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category)
    {
        $categoryId = $category->id;
        $categoryName = $category->name;

        $category->delete();

        ActivityLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'deleted',
            'model' => 'Category',
            'model_id' => $categoryId,
            'description' => 'Deleted category: ' . $categoryName,
        ]);

        flash()->info('Category deleted successfully');

        return redirect()->route('admin.categories.index');
    }
}
