<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{


    public function definition(): array
    {
        $teams = Team::all();

        return [
            'is_home'=> fake()->boolean,
            'pts_team'=> fake()->numberBetween(50,90),
            'pts_op_team'=> fake()->numberBetween(50,90),
            'name_op_team'=> fake()->sentence(3),
            'date_play'=> fake()->dateTimeBetween('-12 months','now')->format('Y-m-d'),
            'team_id'=> $teams[fake()->numberBetween(0, count($teams)-1)]->id,
        ];
    }
}
