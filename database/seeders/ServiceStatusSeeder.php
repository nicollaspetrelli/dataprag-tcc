<?php

namespace Database\Seeders;

use App\Models\ServiceStatus;
use Illuminate\Database\Seeder;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceStatus::create([
            'id' => 1,
            'name' => 'inProgress',
            'description' => 'The service is valid and has not expired yet'
        ]);
        ServiceStatus::create([
            'id' => 2,
            'name' => 'soon',
            'description' => 'The service is about to expire'
        ]);
        ServiceStatus::create([
            'id' => 3,
            'name' => 'expired',
            'description' => 'The service has expired and has not been renewed yet'
        ]);
        ServiceStatus::create([
            'id' => 4,
            'name' => 'finished',
            'description' => 'The service has expired but has been renewed'
        ]);
    }
}
