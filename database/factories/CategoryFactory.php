<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement([
                'Tortas',
                'Tartas',
                'Mini Pasteleria',
                'Shots',
                'Promociones',
            ]),
            'slug' => Str::slug($this->faker->unique()->words(2, true)),
            'orden' => $this->faker->numberBetween(1, 10),
            'activo' => true,
        ];
    }
}
