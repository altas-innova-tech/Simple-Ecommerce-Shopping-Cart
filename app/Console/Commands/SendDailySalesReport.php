<?php

namespace App\Console\Commands;

use App\Features\OrderProduct\Services\SalesReportService;
use Illuminate\Console\Command;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:send-daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a daily sales report to the admin user.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SalesReportService::send_daily_sales_to_admin();

        $this->info('Daily sales report sent successfully.');

        return 0;
    }
}
