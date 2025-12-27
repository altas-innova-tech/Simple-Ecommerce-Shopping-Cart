<?php

namespace App\Features\OrderProduct\Models;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\ColorConstants;
use App\Core\Constants\Constants;
use App\Core\Constants\FeaturesConstants;
use App\Features\Order\Models\Order;
use App\Features\Order\Observers\OrderObserver;
use App\Features\OrderProduct\Observers\OrderProductObserver;
use App\Features\OrderProduct\RenderServices\OrderProductConstantsTrait;
use App\Features\Product\Models\Product;
use Database\Factories\OrderFactory;
use Database\Factories\OrderProductFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(OrderProductObserver::class)]
class OrderProduct extends BaseModel {
    use OrderProductConstantsTrait;
    use HasFactory;

    protected $table = FeaturesConstants::order_product;

    protected $with = ['product'];



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



    public function productRender() : Attribute {
        return new Attribute(
            get: fn() => $this->product->label(),
        );
    }

    //==================================================================================================================
    // Scopes
    //==================================================================================================================
    protected function scopeOrderId(Builder $query, ?int $order_id) : void {
        $query->where('order_id', $order_id);
    }

    //==================================================================================================================
    // Attributes
    //==================================================================================================================


    //==================================================================================================================
    // Methods
    //==================================================================================================================
    public function label() {
        return $this->product->label();
    }
}
