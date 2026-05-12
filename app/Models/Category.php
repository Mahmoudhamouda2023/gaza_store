<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Category extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (Category $category) {
            // حذف صورة القسم
            if ($category->image) {
                File::delete(public_path('images/' . $category->image->path));
                $category->image()->delete();
            }

            // حذف صور المنتجات يدوياً قبل ما DB يحذفهم
            $category->products->each(function (Product $product) {
                foreach ($product->images as $img) {
                    File::delete(public_path('images/' . $img->path));
                }
                $product->images()->delete();
            });
        });
    }

    function products()
    {
        return $this->hasMany(Product::class);
    }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable');
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
