<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Prophecy\Call\Call;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            DocumentsSeeder::class,
            ProductsSeeder::class,
            WaterBoxTypesSeeder::class,
        ]);
    }
}
