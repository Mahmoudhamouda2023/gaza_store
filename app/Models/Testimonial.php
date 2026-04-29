<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    protected $guarded = [];
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
