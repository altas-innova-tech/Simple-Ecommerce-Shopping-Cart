<?php

namespace App\Core\Base\Builders\Navigation;

use AllowDynamicProperties;
use App\Core\Traits\Builders\BuildersMethodsTrait;

#[AllowDynamicProperties]
class NavigationItem {
    use BuildersMethodsTrait;


    public function __construct() {
        $this->items = [];
    }



    public function add_item(NavigationItem $item) : self {
        $this->items[] = $item->get();

        return $this;
    }



    public function get() : array {
        return [
            "label" => $this->label,
            "url"   => $this->url ?? "",
            "icon"  => $this->icon ?? null,
            "badge"  => $this->badge ?? null,
            "items" => $this->items ?? null,
        ];
    }
}
