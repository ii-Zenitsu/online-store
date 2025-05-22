<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'raison_sociale' => $this->faker->company,
            'adresse' => $this->faker->address,
            'tele' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->paragraph,
        ];
    }
}
