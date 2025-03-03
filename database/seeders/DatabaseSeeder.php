<?php

namespace Database\Seeders;

use App\Models\CountryOfManufacture;
use App\Models\ProductType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            CategoryGroupSeeder::class,
            CategorySeeder::class,
            ProductTypeSeeder::class,
            // ManufacturerSeeder::class,
            // TrademarkSeeder::class,
            CountryOfManufactureSeeder::class,
            DataSourceSeeder::class,
            ProductSeeder::class,
            // DietSeeder::class,
            // ActivityCategorySeeder::class,
            // ActivitySeeder::class,
            // DishCategorySeeder::class,
            // DishSeeder::class,
            // DishProductSeeder::class,
        ]);
    }
}
