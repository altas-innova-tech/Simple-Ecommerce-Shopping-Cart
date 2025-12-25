<?php

namespace Database\Factories;

use App\Features\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
class ProductFactory extends Factory {
    protected $model = Product::class;



    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array {
        return [
            'key'            => fake()->uuid(),
            'name'           => fake()->words(3, true),
            'price'          => fake()->randomFloat(2, 10, 1000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
