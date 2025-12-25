<?php

namespace App\Features\Order\FormRequest;

use App\Core\Base\FormRequest\BaseFormRequest;

class OrderFormRequest extends BaseFormRequest {
    public function rules() : array {
        return [
            "user_id" => ["required", "string"],
        ];
    }
}
