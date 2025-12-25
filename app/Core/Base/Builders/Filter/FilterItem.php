<?php

namespace App\Core\Base\Builders\Filter;

use AllowDynamicProperties;
use App\Core\Traits\Builders\BuildersMethodsTrait;

#[AllowDynamicProperties]
class FilterItem {
    use BuildersMethodsTrait;

    private function __construct() {
    }



    public function get() : array {
        return [
            "name"      => $this->name,
            "label"     => $this->label,
            "component" => $this->component ?? null,
            "values"    => $this->values ?? [],
            "value"     => $this->value ?? [],
        ];
    }
}
