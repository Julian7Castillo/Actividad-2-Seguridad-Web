<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /*
    * Array blood type
    */
    protected $blood_type = ["A","B","AB","O"];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $players = Player::all();

        return [
            'medical_public_id'=> fake()->md5(),
            'allergies'=> fake()->sentence(6),
            'injuries'=> fake()->sentence(12),
            'blood_type'=> $this->blood_type[fake()->numberBetween(0, 3)],
            'player_id' => 1
        ];
    }
}
