<?php

namespace App\Features\Product\Jobs;

use App\Core\Base\Job\BaseJob;
use App\Core\Interfaces\JobInterface;
use App\Features\OrderProduct\Services\OrderProductService;

class NotifyAdminOfLowStockJob extends BaseJob implements JobInterface {
    public function process() : void {
        OrderProductService::notify_admin_low_stock($this->params);
    }
}
