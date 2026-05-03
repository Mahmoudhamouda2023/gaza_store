<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('id')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        return view('admin.categories.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ]);


        $data = $request->except('_token', 'image');

        //dd($data);
        $category = Category::create($data);

        $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $img_name);

        $category->image()->create([
            'path' => $img_name
        ]);


        return redirect()
            ->route('admin.categories.index')
            ->with('msg', 'category added successfully')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('_token', 'image');

        if ($request->hasFile('image')) {

            if ($category->image) {
                $oldPath = public_path('images/' . $category->image->path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $category->image()->delete();
            }

            $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $img_name);

            $category->image()->create([
                'path' => $img_name
            ]);
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('msg', 'Category updated successfully')
            ->with('type', 'info');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('msg', 'category deleted successfully')
            ->with('type', 'info');
    }
}
