<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shop@bazaar.com')->first();
        $products = Product::all();

        for ($i = 1; $i <= 30; $i++) {
            $product = $products->random();
            $type = rand(0, 1) ? 'IN' : 'OUT';

            StockMovement::create([
                'product_id' => $product->id,
                'type' => $type,
                'quantity' => rand(5, 30),
                'description' => $type === 'IN' ? 'Stock added' : 'Stock reduced',
                'created_by' => $user->id,
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
