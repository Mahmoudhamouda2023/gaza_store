<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (Product $product) {
            foreach ($product->images as $img) {
                File::delete(public_path('images/' . $img->path));
            }
            $product->images()->delete();
        });
    }

    function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'main');
    }

    function images()
    {
        return $this->morphMany(Image::class, 'imageable');
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

    function getImgPathAttribute()
    {
        $url = 'https://via.placeholder.com/100x80';
        if ($this->image) {
            $url = asset('images/' . $this->image->path);
        }
        return $url;
    }
}
