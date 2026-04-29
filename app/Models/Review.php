<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $guarded = [];

    function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
    function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
