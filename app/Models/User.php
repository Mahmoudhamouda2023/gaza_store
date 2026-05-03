<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable(['name', 'email', 'password', 'type'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Role relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class)->withDefault();
    }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    function reviews()
    {
        return $this->hasMany(Review::class);
    }
    function carts()
    {
        return $this->hasMany(Cart::class);
    }
    function order()
    {
        return $this->hasMany(Order::class);
    }
    function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    function payment()
    {
        return $this->hasMany(Payment::class);
    }
    function testimonial()
    {
        return $this->hasMany(Testimonial::class);
    }
}
