<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /*
    * Array gender
    */
    protected $gender = ["female","male","other"];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'=> fake()->name(),
            'last_name'=> fake()->lastName(),
            'gender'=> $this->gender[fake()->numberBetween(0, 2)],
            'date_birth'=> fake()->dateTimeBetween('-50 years','-6 years')->format('Y-m-d'),
            'user_id'=>1
        ];
    }
}
