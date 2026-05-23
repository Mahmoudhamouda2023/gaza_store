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

            /*
            |--------------------------------------------------------------------------
            | Delete category main image
            |--------------------------------------------------------------------------
            */
            if ($category->image) {
                File::delete(public_path('images/' . $category->image->path));
                $category->image()->delete();
            }

            /*
            |--------------------------------------------------------------------------
            | Delete related product images before deleting products
            |--------------------------------------------------------------------------
            | ملاحظة:
            | هذا الكود يحافظ على نفس منطقك القديم.
            | لا يغير طريقة الحذف الحالية.
            */
            $category->products->each(function (Product $product) {
                foreach ($product->images as $img) {
                    File::delete(public_path('images/' . $img->path));
                }

                $product->images()->delete();
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function image()
    {
        /*
        |--------------------------------------------------------------------------
        | Main category image
        |--------------------------------------------------------------------------
        | أبقيتها بدون where type = main حتى لا يتأثر أي كود قديم.
        | إذا لاحقًا بدك نعتمد main فقط، نضيف where('type', 'main').
        */
        return $this->morphOne(Image::class, 'imageable');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getImgPathAttribute()
    {
        /*
        |--------------------------------------------------------------------------
        | Old accessor
        |--------------------------------------------------------------------------
        | مهم جدًا نتركه كما هو لأن ممكن يكون مستخدم في الداشبورد.
        */
        $url = 'https://via.placeholder.com/100x80';

        if ($this->image && $this->image->path) {
            $url = asset('images/' . $this->image->path);
        }

        return $url;
    }

    public function getImageUrlAttribute()
    {
        /*
        |--------------------------------------------------------------------------
        | New accessor for frontend
        |--------------------------------------------------------------------------
        | هذا مجرد alias جديد للفرونت.
        | لا يؤثر على الكود القديم.
        */
        return $this->img_path;
    }
}
