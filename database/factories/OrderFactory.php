<?php

namespace Database\Factories;

use App\Features\Order\Models\Order;
use App\Features\Order\Services\OrderService;
use App\Features\OrderProduct\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory {

    protected $model = Order::class;
    public function definition() : array {
        return [
            'key'     => fake()->uuid(),
            'user_id' => fake()->numberBetween(2, 3),
            'status' => fake()->randomElement(OrderService::status),
        ];
    }
}
