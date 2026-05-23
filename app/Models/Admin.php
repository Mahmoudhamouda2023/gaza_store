<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guard = 'admin';

    protected $guard_name = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function isAdmin(): bool
    {
        return $this->type === 'admin' || $this->hasRole('admin');
    }

    public function isManager(): bool
    {
        return $this->type === 'manager' || $this->hasRole('manager');
    }

    public function isEmployee(): bool
    {
        return $this->isManager();
    }
}
