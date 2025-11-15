<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shop@bazaar.com')->first();
        $categories = Category::pluck('id')->toArray();
        $suppliers = Supplier::pluck('id')->toArray();

        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $purchasePrice = rand(20, 300);
            $data[] = [
                'name' => "Product $i",
                'category_id' => $categories[array_rand($categories)],
                'supplier_id' => $suppliers[array_rand($suppliers)],
                'purchase_price' => $purchasePrice,
                'selling_price' => $purchasePrice + rand(10, 100),
                'quantity' => rand(20, 200),
                'user_id' => $user->id,
            ];
        }

        Product::insert($data);
    }
}
