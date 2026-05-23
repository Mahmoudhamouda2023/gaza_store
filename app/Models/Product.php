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

            /*
            |--------------------------------------------------------------------------
            | Delete all product images
            |--------------------------------------------------------------------------
            | نفس منطقك القديم بدون تغيير.
            */
            foreach ($product->images as $img) {
                File::delete(public_path('images/' . $img->path));
            }

            $product->images()->delete();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'main');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function gallery()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'gallery');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
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
        | مهم نتركه كما هو لأنه غالبًا مستخدم في الداشبورد.
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
        | هذا alias جديد فقط للواجهة الأمامية.
        | لا يؤثر على أي كود قديم.
        */
        return $this->img_path;
    }

    public function getFormattedPriceAttribute()
    {
        /*
        |--------------------------------------------------------------------------
        | Frontend helper
        |--------------------------------------------------------------------------
        | لتنسيق السعر في واجهة المتجر.
        */
        return number_format((float) $this->price, 2);
    }

    public function getIsAvailableAttribute()
    {
        /*
        |--------------------------------------------------------------------------
        | Frontend helper
        |--------------------------------------------------------------------------
        | لمعرفة إذا المنتج متوفر أو لا.
        */
        return (int) $this->quantity > 0;
    }
}
