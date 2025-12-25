<?php

namespace App\Core\Base\Builders\Navigation;

use App\Core\Base\Builders\BaseBuilder;
use App\Core\Traits\Builders\BuildersMethodsTrait;

class NavigationBuilder extends BaseBuilder {
    use BuildersMethodsTrait;

    public function __construct() {
        parent::__construct();
    }



    public function get() : array {
        return $this->items;
    }
}
