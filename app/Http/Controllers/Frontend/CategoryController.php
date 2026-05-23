<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $category->load('image');

        $products = $category->products()
            ->with(['image', 'category'])
            ->latest()
            ->paginate(12);

        return view('frontend.categories.show', compact('category', 'products'));
    }
}
