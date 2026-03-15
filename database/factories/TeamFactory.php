<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /*
    * Array gender
    */
    protected $gender = ["female","male","mixed"];

    /*
    * Array category
    */
    protected $category = ['prebenjamines','benjamines','alevines','infantiles','cadete','junior','senior'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->sentence(3),
            'category'=> $this->category[fake()->numberBetween(0, 6)],
            'gender'=> $this->gender[fake()->numberBetween(0, 2)],
        ];
    }
}
