<?php

namespace App\Features\OrderProduct\Observers;


use App\Features\OrderProduct\Models\OrderProduct;
use App\Features\Product\Jobs\NotifyAdminOfLowStockJob;
use Illuminate\Support\Facades\Log;

class OrderProductObserver {
    /**
     * Handle the OrderProduct "created" event.
     */
    public function created(OrderProduct $order_product) : void {
        //
        $params['order_product'] = $order_product;
        NotifyAdminOfLowStockJob::dispatch($params);




        // Decrement the product stock quantity
        $product = $order_product->product;
        $product->decrement('stock_quantity', $order_product->quantity);
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
        // increment the product stock quantity
        $product = $order_product->product;
        $product->increment('stock_quantity', $order_product->quantity);
    }
}
