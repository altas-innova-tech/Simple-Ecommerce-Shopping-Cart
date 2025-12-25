<?php

namespace App\Core\Base\Builders\Action;

use App\Core\Base\Builders\BaseBuilder;
use App\Core\Traits\Builders\BuildersMethodsTrait;

class ActionBuilder extends BaseBuilder {
    use BuildersMethodsTrait;


    public function get() : array {
        return $this->items;
    }
}
