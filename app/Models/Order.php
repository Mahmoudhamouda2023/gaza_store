<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = [];
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function order_details()
    {
        return $this->belongsTo(OrderDetail::class);
    }
    function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
