<?php

namespace App\Features\Order\Controllers;

use App\Core\Base\Controller\BaseController;
use App\Core\Traits\Features\CrudTrait;
use App\Features\Order\RenderServices\OrderConstantsTrait;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class OrderController extends BaseController {
    use CrudTrait;
    use OrderConstantsTrait;
}
