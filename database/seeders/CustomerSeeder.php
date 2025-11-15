<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $data[] = [
                'name' => "Customer $i",
                'contact' => '98' . rand(11111111, 99999999),
                'email' => "customer$i@example.com",
            ];
        }

        Customer::insert($data);
    }
}
