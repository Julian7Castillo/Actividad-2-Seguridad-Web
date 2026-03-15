<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Llamamos a todos los seeders de forma ordenada
        $this->call([
            UserSeeder::class,
            PlayerSeeder::class,
            TeamSeeder::class,
            MedicalRecordSeeder::class,
            GameSeeder::class,
            TeamPlayerSeeder::class,
            ImageSeeder::class
        ]);
    }
}
