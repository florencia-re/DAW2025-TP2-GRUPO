<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //Crea usuarios de prueba
        \App\Models\User::factory(5)->create();

        // Crea usuario admin
        $this->call(AdminSeeder::class);
    }
}
