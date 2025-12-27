<?php

namespace Database\Seeders;

use App\Features\Order\Models\Order;
use App\Features\OrderProduct\Models\OrderProduct;
use Illuminate\Database\Seeder;

class OrderProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run() : void {
        OrderProduct::factory()
                    ->count(30)
                    ->create();
    }
}
