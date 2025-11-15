<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::pluck('id')->toArray();

        for ($i = 1; $i <= 30; $i++) {
            Sale::create([
                'customer_id' => $customers[array_rand($customers)],
                'total_amount' => rand(200, 5000),
                'discount' => rand(0, 200),
                'tax' => rand(0, 300),
                'payment_method' => 'Cash',
                'sale_date' => Carbon::now()->subDays(rand(1, 20)),
            ]);
        }
    }
}
