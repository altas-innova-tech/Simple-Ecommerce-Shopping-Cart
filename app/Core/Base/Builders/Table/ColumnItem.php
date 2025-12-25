<?php

namespace App\Core\Base\Builders\Table;

use AllowDynamicProperties;
use App\Core\Traits\Builders\BuildersMethodsTrait;

#[AllowDynamicProperties]
class ColumnItem {
    use BuildersMethodsTrait;

    public function __construct() {
        $this->searchable = false;
        $this->triable    = false;
    }



    public function get() : array {
        return [
            "name"       => $this->name,
            "label"      => $this->label,
            "component"  => $this->component ?? null,
            "searchable" => $this->searchable,
            "triable"    => $this->triable,
        ];
    }
}
