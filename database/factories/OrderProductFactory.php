<?php

namespace Database\Factories;

use App\Features\Order\Models\Order;
use App\Features\OrderProduct\Models\OrderProduct;
use App\Features\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $order = Order::inRandomOrder()->first();

        return [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $product->price,
        ];
    }
}
