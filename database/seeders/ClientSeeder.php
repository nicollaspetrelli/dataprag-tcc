<?php

namespace Database\Seeders;

use App\Models\Clients;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        Clients::factory(5)->legal()->create();
        Clients::factory(5)->individual()->create();

        Service::factory(10)->create();
    }
}
