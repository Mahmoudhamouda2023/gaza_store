<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Product::with(['image', 'category']); // بدون is_active

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
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

        $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $img_name);

        $product->images()->create([
            'path' => $img_name,
            'type' => 'main',
        ]);

        foreach ($request->gallery as $img) {
            $img_name = rand() . time() . $img->getClientOriginalName();
            $img->move(public_path('images'), $img_name);

            $product->images()->create([
                'path' => $img_name,
                'type' => 'gallery',
            ]);
        }

        ActivityLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'created',
            'model' => 'Product',
            'model_id' => $product->id,
            'description' => 'Created product: ' . $product->name,
        ]);

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

        if ($request->hasFile('image')) {
            if ($product->image) {
                File::delete(public_path('images/' . $product->image->path));
                $product->image()->delete();
            }

            $img_name = rand() . time() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $img_name);

            $product->images()->create([
                'path' => $img_name,
                'type' => 'main',
            ]);
        }

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
                    'type' => 'gallery',
                ]);
            }
        }

        ActivityLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'updated',
            'model' => 'Product',
            'model_id' => $product->id,
            'description' => 'Updated product: ' . $product->name,
        ]);

        flash()->success('تم تعديل المنتج بنجاح!');

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product)
    {
        $productId = $product->id;
        $productName = $product->name;

        $product->delete();

        ActivityLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => 'deleted',
            'model' => 'Product',
            'model_id' => $productId,
            'description' => 'Deleted product: ' . $productName,
        ]);

        flash()->info('تم حذف المنتج بنجاح!');

        return redirect()->route('admin.products.index');
    }
}
