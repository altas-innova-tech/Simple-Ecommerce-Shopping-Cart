<?php

namespace App\Features\OrderProduct\Observers;


use App\Features\OrderProduct\Models\OrderProduct;

class OrderProductObserver {
    /**
     * Handle the OrderProduct "created" event.
     */
    public function created(OrderProduct $order_product) : void {
        //
    }



    /**
     * Handle the OrderProduct "updated" event.
     */
    public function updated(OrderProduct $order_product) : void {
        //
    }



    /**
     * Handle the OrderProduct "deleted" event.
     */
    public function deleted(OrderProduct $order_product) : void {
        //
    }
}
