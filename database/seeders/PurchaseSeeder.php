<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shop@bazaar.com')->first();
        $products = Product::all();

        foreach ($products as $product) {
            Purchase::create([
                'supplier_id'    => $product->supplier_id,
                'name'           => $product->name,
                'quantity'       => rand(10, 50),
                'purchase_price' => $product->purchase_price,
                'purchase_date'  => Carbon::now()->subDays(rand(1, 60)),
                'user_id'        => $user->id,
            ]);
        }
    }
}
