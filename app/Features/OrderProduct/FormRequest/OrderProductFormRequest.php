<?php

namespace App\Features\OrderProduct\FormRequest;

use App\Core\Base\FormRequest\BaseFormRequest;
use App\Core\Constants\FeaturesConstants;
use App\Features\OrderProduct\Models\OrderProduct;
use App\Features\Product\Models\Product;
use Illuminate\Validation\Rule;

class OrderProductFormRequest extends BaseFormRequest {
    public function rules() : array {
        $order_product_key     = $this->input("key");
        $current_order_product = OrderProduct::get_by_key($order_product_key);


        return [
            "quantity"   => ["required", "integer", "min:1"],
            "product_id" => [
                "required",
                "integer",
                "min:1",
                Rule::exists(FeaturesConstants::product, "id"),
            ],
            "order_id"   => [
                "required",
                "integer",
                Rule::exists(FeaturesConstants::order, "id"),
                Rule::unique(FeaturesConstants::order, "id")
                    ->ignore($current_order_product),
            ],
        ];
    }



    public function validated($key = null, $default = null) {
        $attributes = parent::validated($key, $default);

        $product = Product::find($attributes["product_id"]);

        $attributes['price'] = $product->price;

        return $attributes;
    }
}
