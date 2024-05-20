<?php

namespace Database\Seeders;

use App\Models\WaterBoxType;
use Illuminate\Database\Seeder;

class WaterBoxTypesSeeder extends Seeder
{
    public function run()
    {
        WaterBoxType::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Polipropileno',
            ]
        );
        WaterBoxType::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'Metálica',
            ]
        );
        WaterBoxType::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Amianto',
            ]
        );
        WaterBoxType::firstOrCreate(
            ['id' => 4],
            [
                'name' => 'Plastica',
            ]
        );
        WaterBoxType::firstOrCreate(
            ['id' => 5],
            [
                'name' => 'Cimento',
            ]
        );
        WaterBoxType::firstOrCreate(
            ['id' => 6],
            [
                'name' => 'Alvenaria',
            ]
        );
        WaterBoxType::firstOrCreate(
            ['id' => 7],
            [
                'name' => 'Subterrânea',
            ]
        );
    }
}
