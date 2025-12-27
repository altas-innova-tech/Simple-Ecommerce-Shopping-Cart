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
            'user_id' => fake()->numberBetween(2, 4),
            'status'  => OrderService::status_completed,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            OrderProduct::factory()->count(3)->create([
                'order_id' => $order->id,
            ]);
        });
    }
}
