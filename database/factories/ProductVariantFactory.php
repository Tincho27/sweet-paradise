<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'nombre' => $this->faker->randomElement([
                'Chica',
                'Mediana',
                'Grande',
                'Unica',
                'Promo Especial',
            ]),
            'precio' => $this->faker->randomFloat(2, 2500, 25000),
            'stock' => $this->faker->randomFloat(2, 0, 40),
            'sku' => strtoupper($this->faker->bothify('SP-###-??')),
            'activo' => true,
        ];
    }
}
