<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bazaar.com',
            'password' => bcrypt('admin'),
            'is_admin' => true,
        ]);

        // Unique user
        User::create([
            'name' => 'Unique User',
            'email' => 'unique@bazaar.com',
            'password' => bcrypt('unique123'),
            'is_admin' => false,
        ]);

        // Shopkeeper user (main data belongs to this user)
        User::create([
            'name' => 'Shopkeeper User',
            'email' => 'shop@bazaar.com',
            'password' => bcrypt('shopkeeper'),
            'is_admin' => false,
        ]);
    }
}
