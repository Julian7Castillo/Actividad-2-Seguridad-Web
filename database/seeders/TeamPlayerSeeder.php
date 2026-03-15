<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;

class TeamPlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los teams y players
        $teams = Team::all();
        $players = Player::all();

        // Por ejemplo, asignar aleatoriamente jugadores a equipos
        foreach ($teams as $team) {
            // Adjunta 3 jugadores aleatorios a cada equipo
            $team->players()->attach(
                $players->random(8)->pluck('id')->toArray()
            );
        }
    }
}
