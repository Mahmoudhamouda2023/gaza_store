<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'main');
    }

    function gallery()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'gallery');
    }
    function reviews()
    {
        return $this->hasMany(Review::class);
    }
    function carts()
    {
        return $this->hasMany(Cart::class);
    }
    function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
