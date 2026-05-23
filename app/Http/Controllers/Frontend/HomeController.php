<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('image')
            ->latest()
            ->take(4)
            ->get();

        $latestProducts = Product::with(['image', 'category'])
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.home', compact('categories', 'latestProducts'));
    }
}
