<?php

namespace App\Features\Product\Models;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\ColorConstants;
use App\Core\Constants\Constants;
use App\Core\Constants\FeaturesConstants;
use App\Features\Product\Observers\ProductObserver;
use App\Features\Product\RenderServices\ProductConstantsTrait;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy(ProductObserver::class)]
class Product extends BaseModel {
    use ProductConstantsTrait;
    use HasFactory;

    protected $table = FeaturesConstants::product;



    protected static function newFactory() {
        return ProductFactory::new();
    }


    //==================================================================================================================
    // Scopes
    //==================================================================================================================
    protected function scopeInStock(Builder $query) : void {
        $query->where('stock_quantity', ">", 0);
    }

    //==================================================================================================================
    // Relations
    //==================================================================================================================
    public function getStatusRenderAttribute() : array {
        $is_out_stock = $this->stock_quantity > 0;

        if ($is_out_stock) {
            return [
                Constants::label => "Out of stock",
                Constants::color => ColorConstants::red,
            ];
        }


        return [
            Constants::label => "In stock",
            Constants::color => ColorConstants::green,
        ];
    }

    //==================================================================================================================
    // Methods
    //==================================================================================================================
    public function label() {
        return $this->name;
    }
}
