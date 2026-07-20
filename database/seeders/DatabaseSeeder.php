<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            InspirationSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            EliteCatalogSeeder::class,
            ReviewSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
