<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'nombre' => $this->faker->unique()->words(3, true),
            'descripcion' => $this->faker->paragraph(),
            'destacado_home' => $this->faker->boolean(35),
            'promo' => $this->faker->boolean(20),
            'activo' => true,
        ];
    }
}
