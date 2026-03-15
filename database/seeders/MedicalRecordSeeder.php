<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Player;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los players
        $players = Player::all();

        // Por ejemplo, asignar aleatoriamente jugadores a equipos
        foreach ($players as $player) {
            MedicalRecord::factory()->create(['player_id'=>$player->id]);
        }
    }
}
