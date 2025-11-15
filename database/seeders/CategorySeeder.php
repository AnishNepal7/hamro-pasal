<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shop@bazaar.com')->first();

        $baseCategories = [
            'Beverages', 'Snacks', 'Personal Care', 'Cleaning Supplies', 'Stationery',
            'Frozen Foods', 'Bakery Items', 'Baby Care', 'Electronics', 'Dairy Products',
            'Grains', 'Household Items', 'Pet Food', 'Cosmetics', 'Vegetables',
            'Fruits', 'Health Supplements', 'Breakfast Items', 'Meat Products', 'Kitchen Needs',
            'Gadgets', 'Footwear', 'Gardening', 'Lighting', 'Home Decor',
            'Spices', 'Condiments', 'Canned Goods', 'Seasonal Items', 'Organic Foods'
        ];

        $data = [];
        foreach ($baseCategories as $cat) {
            $data[] = [
                'name' => $cat,
                'user_id' => $user->id,
            ];
        }

        Category::insert($data);
    }
}
