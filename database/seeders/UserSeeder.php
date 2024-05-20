<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // Seeda a tabela de USERS
    public function run()
    {
        // Cria Usuario Nicollas
        User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Nicollas Feitosa',
                'email' => 'contato@nicollas.dev',
                'password' => Hash::make('sonic9595'),
                'picture' => 'https://i.imgur.com/3qkopXU.png'
            ]
        );

        //User::factory(2)->create();
    }
}
