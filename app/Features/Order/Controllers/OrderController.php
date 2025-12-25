<?php

namespace App\Features\Order\Controllers;

use App\Core\Base\Controller\BaseController;
use App\Core\Traits\Features\CrudTrait;
use App\Features\Order\RenderServices\OrderConstantsTrait;

class OrderController extends BaseController {
    use CrudTrait;
    use OrderConstantsTrait;
}
