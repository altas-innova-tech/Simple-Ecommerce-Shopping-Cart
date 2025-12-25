<?php

namespace App\Features\OrderProduct\Controllers;

use App\Core\Base\Controller\BaseController;
use App\Core\Traits\Features\CrudTrait;
use App\Features\OrderProduct\RenderServices\OrderProductConstantsTrait;
use App\Features\Product\RenderServices\ProductConstantsTrait;

class OrderProductController extends BaseController {
    use CrudTrait;
    use OrderProductConstantsTrait;
}
