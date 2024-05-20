<?php

namespace Database\Factories;

use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientsFactory extends Factory
{
    protected $model = Clients::class;

    // Esse é o método comum entre os dois tipos de Clients
    public function definition()
    {
        return [
            'street' => $this->faker->unique()->streetName,
            'neighborhood' => $this->faker->country,
            'number' => $this->faker->randomNumber(3),
            'zipCode' => $this->faker->numerify('##.###-###'),
            'city' => $this->faker->randomElement(['Araras', 'Leme', 'Rio Claro', 'Campinas']),
            'state' => 'SP',
            'referencePoint' => 'Ponto de Referencia do Cliente',
            'notes' => 'Notas do Cliente',
            'respName' => $this->faker->name,
            'respPhone' => $this->faker->phoneNumber,
            'respEmail' => $this->faker->companyEmail,
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }

    // Método para criar Pessoas Físicas - CPF
    public function individual()
    {
        return $this->state(function () {
            $name = $this->faker->company;
            $document = $this->faker->numerify('###.###.###-##');

            return [
                'fantasyName' => $name,
                'companyName' => $name,
                'identificationName' => $name,
                'documentNumber' => $document,
                'type' => 1,
            ];
        });
    }

    // Método para criar Pessoas Júridicas - CNPJ
    public function legal()
    {
        return $this->state(function () {
            $name = $this->faker->company;
            $document = $this->faker->numerify('##.###.###/000#-##');

            return [
                'fantasyName' => $name,
                'companyName' => $name,
                'identificationName' => $name,
                'documentNumber' => $document,
                'type' => 0,
            ];
        });
    }
}
