<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return [
            'status' => true,
            'message' => 'All Products',
            'products' => ProductResource::collection(
                Product::with(['images', 'category'])->get()
            )
        ];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'image'       => 'required|image',
            'gallery'     => 'required',
            'gallery.*'   => 'image',
            'price'       => 'required',
            'description' => 'required',
            'quantity'    => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        // $data = $request->except('image', 'gallery');

        // $product = Product::create($data);
        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'quantity'    => $request->quantity,
            'category_id' => $request->category_id,
        ]);
        // Save main image
        $img_name = rand() . time() . $request->file('image')->getClientOriginalName();

        $request->file('image')->move(public_path('images'), $img_name);
        // $product->images()->create(['path' => $img_name]);
        $product->images()->create([
            'path' => $img_name,
            'type' => 'main',
        ]);

        // Save gallery images
        // foreach ($request->file('gallery') as $img) {
        //     $img_name = rand() . time() . $img->getClientOriginalName();

        //     $img->move(public_path('images'), $img_name);

        //     $product->images()->create([
        //         'path' => $img_name,
        //         'type' => 'gallery',
        //     ]);
        // }
        foreach ($request->file('gallery') as $img) {
            $img_name = rand() . time() . $img->getClientOriginalName();
            $img->move(public_path('images'), $img_name);

            $product->images()->create([
                'path' => $img_name,
                'type' => 'gallery'
            ]);
        }

        return response()->json([
            'status'  => 'true',
            'message' => 'New Product added',
            'product' => new ProductResource($product->load(['images', 'category']))

        ], 201);
    }



    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
