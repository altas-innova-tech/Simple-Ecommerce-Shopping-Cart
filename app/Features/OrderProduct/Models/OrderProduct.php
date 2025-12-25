<?php

namespace App\Features\OrderProduct\Models;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\FeaturesConstants;
use App\Features\Order\Models\Order;
use App\Features\Order\Observers\OrderObserver;
use App\Features\OrderProduct\Observers\OrderProductObserver;
use App\Features\OrderProduct\RenderServices\OrderProductConstantsTrait;
use App\Features\Product\Models\Product;
use Database\Factories\OrderFactory;
use Database\Factories\OrderProductFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(OrderProductObserver::class)]
class OrderProduct extends BaseModel {
    use OrderProductConstantsTrait;
    use HasFactory;

    protected $table = FeaturesConstants::order_product;



    protected static function newFactory() {
        return OrderProductFactory::new();
    }


    //==================================================================================================================
    // Relations
    //==================================================================================================================
    public function order() : BelongsTo {
        return $this->belongsTo(Order::class, "order_id");
    }



    public function product() : BelongsTo {
        return $this->belongsTo(Product::class, "product_id");
    }

    //==================================================================================================================
    // Methods
    //==================================================================================================================
    public function label() {
        return $this->name;
    }
}
