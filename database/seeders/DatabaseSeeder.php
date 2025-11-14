<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //Crea usuarios de prueba
        User::factory(5)->create();

        // Crea usuario admin
        $this->call(AdminSeeder::class);

        $clients = [
            [
                'name' => 'Alba Ines',
                'cuit' => '1209312094',
                'email' => 'albita@gmail.com',
                'phone' => '123456789',
                'address' => 'Calle Falsa 123'
            ],
            [
                'name' => 'Juan Ignacio',
                'cuit' => '20377138792',
                'email' => 'juanitop@gmail.com',
                'phone' => '3425155063',
                'address' => 'Peatonal b 123'
            ],
            [
                'name' => 'Francisco Colombara',
                'cuit' => '11111111111',
                'email' => 'francisco@gmail.com',
                'phone' => '987654321',
                'address' => 'Calle Verdadera 123'
            ],
            [
                'name' => 'Mariana Lopez',
                'cuit' => '11111111115',
                'email' => 'mariana@gmail.com',
                'phone' => '1231231234',
                'address' => 'Calle Falsa 456'
            ],
            [
                'name' => 'Sofia Garcia',
                'cuit' => '90333333339',
                'email' => 'sofia@gmail.com',
                'phone' => '5678901234',
                'address' => 'Calle Verdadera 789'
            ],
            [
                'name' => 'Milo J',
                'cuit' => '99999999999',
                'email' => 'milo@gmail.com',
                'phone' => '4445556666',
                'address' => 'Avenida Siempre Viva 742'
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
