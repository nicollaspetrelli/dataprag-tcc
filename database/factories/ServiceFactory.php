<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = [];

        if (rand(0,1)) {
            $date = [
                'dateExecution' => Carbon::now()->subMonth(rand(6,7)),
                'dateValidity' => Carbon::now()
            ];
        } else {
            $date = [
                'dateExecution' => Carbon::now(),
                'dateValidity' => Carbon::now()->addMonth(6)
            ];
        }

        return [
            'value' => rand(10, 1000),
            'dateExecution' => $date['dateExecution'],
            'dateValidity' => $date['dateValidity'],
            'clients_id' => rand(1, 10),
            'value' => rand(250, 1000),
            'documents_id' => rand(1, 3),
        ];
    }
}
