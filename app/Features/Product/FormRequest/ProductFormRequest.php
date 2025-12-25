<?php

namespace App\Features\Product\FormRequest;

use App\Core\Base\FormRequest\BaseFormRequest;

class ProductFormRequest extends BaseFormRequest {
    public function rules() : array {
        return [
            "name" => ["required", "string"],
            "price" => ["required", "decimal:2"],
            "stock_quantity" => ["required", "integer", "min:1"],
        ];
    }
}
