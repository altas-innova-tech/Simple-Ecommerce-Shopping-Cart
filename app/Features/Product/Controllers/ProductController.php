<?php

namespace App\Features\Product\Controllers;

use App\Core\Base\Controller\BaseController;
use App\Core\Traits\Features\CrudTrait;
use App\Features\Product\RenderServices\ProductConstantsTrait;

class ProductController extends BaseController {
    use CrudTrait;
    use ProductConstantsTrait;
}
