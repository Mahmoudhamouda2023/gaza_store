<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@gazastore.com',
            'password' => Hash::make('password123'),
            'type'     => 'admin',
            'role_id'  => null,
        ]);
    }
}
