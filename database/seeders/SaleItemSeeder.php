<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Database\Seeder;

class SaleItemSeeder extends Seeder
{
    public function run(): void
    {
        $sales = Sale::all();
        $products = Product::all();

        foreach ($sales as $sale) {
            $product = $products->random();

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
                'selling_price' => $product->selling_price,
                'sale_date' => $sale->sale_date,
            ]);
        }
    }
}
