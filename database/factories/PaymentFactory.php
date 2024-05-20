<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $key = array_rand(Payment::METHOD_LABELS);
        $paymentMethod = Payment::METHOD_LABELS[$key];

        return [
            'description' => $this->faker->words(),
            'paymentMethod' => $paymentMethod,
            'paymentDate' => now(),
            'totalValue' => rand(10, 350)
        ];
    }
}
