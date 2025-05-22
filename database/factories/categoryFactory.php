<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\category>
 */
class categoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $name = $this->faker->unique()->words(2, true); // Ex : "Tech mobile", "Sport extrême"
        return [
            'name' => ucfirst($name),
            'description' => $this->faker->sentence(10),
        ];
    }
}
