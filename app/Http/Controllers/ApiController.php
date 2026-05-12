<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    function products()
    {
        $products = Http::withoutVerifying()
            ->get('https://dummyjson.com/products')
            ->json();

        $products = $products['products'];

        return view('api.products', compact('products'));
    }

    function weather()
    {
        return view('api.weather');
    }
}
