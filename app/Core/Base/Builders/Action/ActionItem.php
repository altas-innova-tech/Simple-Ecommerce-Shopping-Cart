<?php

namespace App\Core\Base\Builders\Action;

use AllowDynamicProperties;
use App\Core\Base\Traits\ActionItemMethodsTrait;
use App\Core\Constants\Constants;
use App\Core\Services\MethodeServices;
use App\Core\Traits\Builders\BuildersMethodsTrait;

#[AllowDynamicProperties]
class ActionItem {
    use ActionItemMethodsTrait;
    use BuildersMethodsTrait;


    public function __construct() {
        $this->method                      = MethodeServices::GET;
        $this->url                         = null;
        $this->type                        = Constants::button_type_default;
        $this->button_confirme             = false;
        $this->button_add_to_cart          = false;
        $this->button_confirme_label       = null;
        $this->button_confirme_description = null;
        $this->button_type                 = Constants::button_type_button;
        $this->permission                  = null;
        $this->model                       = null;
    }



    public function get() : array {
        return [
            "label"                       => $this->label,
            "color"                       => $this->color,
            "icon"                        => $this->icon,
            "url"                         => $this->url,
            "method"                      => $this->method,
            "type"                        => $this->type,
            "button_confirme"             => $this->button_confirme,
            "button_add_to_cart"          => $this->button_add_to_cart,
            "model"                       => $this->model,
            "button_confirme_label"       => $this->button_confirme_label,
            "button_confirme_description" => $this->button_confirme_description,
            "permission"                  => $this->permission,
        ];
    }
}
