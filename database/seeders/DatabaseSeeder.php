<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            PurchaseSeeder::class,
            // PurchaseItemSeeder::class,
            CustomerSeeder::class,
            SaleSeeder::class,
            SaleItemSeeder::class,
            StockMovementSeeder::class,
            // ProductSeeder::class,
            // CategorySeeder::class,
        ]);
    }
}