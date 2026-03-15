<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Image;
use App\Models\Player;
use App\Models\Team;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar imágenes a Players
        Player::all()->each(function ($player) {
            $player->image()->create(
                Image::factory()->make()->toArray()
            );
        });

        // Asignar imágenes a Teams
        Team::all()->each(function ($team) {
            $team->image()->create(
                Image::factory()->make()->toArray()
            );
        });
    }
}