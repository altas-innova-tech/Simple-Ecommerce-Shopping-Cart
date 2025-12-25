<?php

namespace App\Features\Product\Models;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\FeaturesConstants;
use App\Features\Product\Observers\ProductObserver;
use App\Features\Product\RenderServices\ProductConstantsTrait;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy(ProductObserver::class)]
class Product extends BaseModel {
    use ProductConstantsTrait;
    use HasFactory;

    protected $table = FeaturesConstants::product;


    protected static function newFactory()
    {
        return ProductFactory::new();
    }


    //==================================================================================================================
    // Relations
    //==================================================================================================================


    //==================================================================================================================
    // Methods
    //==================================================================================================================
    public function label() {
        return $this->name;
    }
}
