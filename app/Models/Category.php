<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = [];
    function product()
    {

        return $this->hasMany(Product::class);
    }
    function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
