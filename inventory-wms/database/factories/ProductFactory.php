<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'sku' => 'SKU-'.fake()->unique()->numerify('###'),
            'name' => fake()->words(2, true),
            'unit' => 'pcs',
            'quantity' => fake()->numberBetween(0, 120),
            'safety_stock' => 10,
            'location' => 'A-'.fake()->numberBetween(1, 9),
            'notes' => null,
        ];
    }
}
