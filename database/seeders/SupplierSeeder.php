<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'shop@bazaar.com')->first();

        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $data[] = [
                'user_id' => $user->id,
                'name' => "Supplier $i",
                'company' => "Company $i Pvt. Ltd.",
                'contact' => '98' . rand(00000000, 99999999),
                'email' => "supplier$i@example.com",
                'address' => "Area $i, Kathmandu",
            ];
        }

        Supplier::insert($data);
    }
}
