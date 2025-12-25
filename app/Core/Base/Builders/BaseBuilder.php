<?php

namespace App\Core\Base\Builders;

class BaseBuilder {
    protected array $items = [];



    public function __construct() {
    }



    public function add_item($item) : self {
        $this->items[] = $item->get();

        return $this;
    }



    public function get() : array {
        return $this->items;
    }

}
