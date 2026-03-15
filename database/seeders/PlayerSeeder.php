<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Player;
use App\Models\User;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los users
        $users = User::all();

        // Por ejemplo, asignar aleatoriamente jugadores a equipos
        foreach ($users as $user) {
            Player::factory()->create(['user_id'=>$user->id]);
        }
    }
}
