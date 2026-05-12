<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest('id')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $product = new Product();
        return view('admin.products.create', compact('categories', 'product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'image'       => 'required',
            'gallery'     => 'required',
            'price'       => 'required',
            'description' => 'required',
            'quantity'    => 'required',
            'category_id' => 'required',
        ]);

        $data = $request->except('_token', 'image', 'gallery');
        $product = Product::create($data);

        // ✅ حفظ الصورة الرئيسية مع type => main
        $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $img_name);
        $product->images()->create([
            'path' => $img_name,
            'type' => 'main'
        ]);

        // ✅ حفظ صور الغاليري مع type => gallery
        foreach ($request->gallery as $img) {
            $img_name = rand() . time() . $img->getClientOriginalName();
            $img->move(public_path('images'), $img_name);
            $product->images()->create([
                'path' => $img_name,
                'type' => 'gallery'
            ]);
        }

        flash()->success('تم إضافة المنتج بنجاح!');
        return redirect()->route('admin.products.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required',
            'description' => 'required',
            'quantity'    => 'required',
            'category_id' => 'required',
            'image'       => 'nullable|file',
            'gallery'     => 'nullable|array',
        ]);

        $product->update($request->except('_token', '_method', 'image', 'gallery'));

        // ✅ تحديث الصورة الرئيسية
        if ($request->hasFile('image')) {
            File::delete(public_path('images/' . $product->image?->path));
            $product->image()->delete();

            $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $img_name);
            $product->images()->create([
                'path' => $img_name,
                'type' => 'main'
            ]);
        }

        // ✅ تحديث صور الغاليري
        if ($request->hasFile('gallery')) {
            foreach ($product->gallery as $img) {
                File::delete(public_path('images/' . $img->path));
            }
            $product->gallery()->delete();

            foreach ($request->gallery as $img) {
                $img_name = rand() . time() . $img->getClientOriginalName();
                $img->move(public_path('images'), $img_name);
                $product->images()->create([
                    'path' => $img_name,
                    'type' => 'gallery'
                ]);
            }
        }

        flash()->success('تم تعديل المنتج بنجاح!');
        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        flash()->info('تم حذف المنتج بنجاح!');
        return redirect()->route('admin.products.index');
    }
}
