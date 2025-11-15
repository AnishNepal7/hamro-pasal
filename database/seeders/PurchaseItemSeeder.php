<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseItem;

class PurchaseItemSeeder extends Seeder
{
    public function run(): void
    {
        $purchases = Purchase::all();

        foreach ($purchases as $purchase) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $purchase->product_id,
                'quantity' => $purchase->quantity,
                'cost_price' => $purchase->purchase_price,
            ]);
        }
    }
}
