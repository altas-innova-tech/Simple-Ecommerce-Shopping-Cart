<?php

namespace App\Core\Base\FormRequest;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest {

    //    public function all($keys = null) {
    //        $data = parent::all($keys);
    //
    //        return array_merge($data, $this->route()
    //                                       ->parameters());
    //    }


    //==================================================================================================================
    // Personalisation des messages de validation
    //==================================================================================================================
    public function messages() : array {
        return [
            "required" => "The :attribute field is required.",
            "email"    => "The :attribute field must be a valid email address.",
            "string"   => "The :attribute field must be a string.",

            // Numeric
            "numeric"  => "The :attribute field must be a number.",
            "integer"  => "The :attribute field must be an integer.",

            // Length
            'min'      => [
                'string'  => 'The :attribute field must be at least :min characters.',
                'numeric' => 'The :attribute field must be greater than or equal to :min.',
            ],
            'max'      => [
                'string'  => 'The :attribute field must not exceed :max characters.',
                'numeric' => 'The :attribute field must not be greater than :max.',
            ],
            'between'  => 'The :attribute field must be between :min and :max characters.',

            // Unique
            'unique'   => 'The :attribute value has already been taken.',

            // Date
            'date'     => 'The :attribute field must be a valid date. The correct format is :format.',
            'after'    => 'The end date must be after :attribute.',

            // Other
            "array"    => "The :attribute field must be an array.",
            "in"       => "The :attribute field must be one of the following values: :values.",
            'regex'    => 'The :attribute field format is invalid.',
            "nullable" => 'The :attribute field may be empty.',
            'exists'   => 'The selected :attribute is invalid.',
            'distinct' => 'The :attribute has a duplicate value.',
        ];
    }
}
