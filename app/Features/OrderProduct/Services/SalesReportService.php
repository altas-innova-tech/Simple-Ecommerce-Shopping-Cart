<?php

namespace App\Features\OrderProduct\Services;

use App\Core\Base\Builders\Mail\MailBuilder;
use App\Features\Order\Models\Order;
use App\Features\Template\Services\TemplateService;
use App\Models\User;

class SalesReportService {
    public static function send_daily_sales_to_admin() : void {
        $admin = User::admin()
                     ->first();

        if (!$admin) {
            return;
        }

        $sales = Order::completed()
                      ->whereDate('updated_at', today())
                      ->with(['user', 'products.product'])
                      ->get()
                      ->groupBy('user_id');

        $sales_summary_html = self::generate_sales_summary_html($sales);

        MailBuilder::new()
                   ->set_from_owner()
                   ->recipient($admin->email, $admin->name)
                   ->subject('Daily Sales Report')
                   ->tag('sales_summary', $sales_summary_html)
                   ->template(TemplateService::daily_sales_report)
                   ->send();
    }



    private static function generate_sales_summary_html($sales_by_user) : string {
        if ($sales_by_user->isEmpty()) {
            return '<p>No sales today.</p>';
        }

        $html        = '';
        $grand_total = 0;

        foreach ($sales_by_user as $user_id => $sales) {
            $user = $sales->first()->user;
            $html .= '<h2>User: ' . $user->name . ' (' . $user->email . ')</h2>';
            $html .= '<table>';
            $html .= '<thead><tr><th>Order ID</th><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead>';
            $html .= '<tbody>';

            $user_total = 0;

            foreach ($sales as $order) {
                foreach ($order->products as $order_product) {
                    $total_price = $order_product->price * $order_product->quantity;
                    $html        .= '<tr>';
                    $html        .= '<td>' . $order->id . '</td>';
                    $html        .= '<td>' . $order_product->product->name . '</td>';
                    $html        .= '<td>' . $order_product->quantity . '</td>';
                    $html        .= '<td>$' . number_format($order_product->price, 2) . '</td>';
                    $html        .= '<td>$' . number_format($total_price, 2) . '</td>';
                    $html        .= '</tr>';
                }
                $user_total += $order->get_total();
            }

            $html .= '</tbody>';
            $html .= '<tfoot><tr><td colspan="4">User Total</td><td>$' . number_format($user_total, 2) . '</td></tr></tfoot>';
            $html .= '</table>';

            $grand_total += $user_total;
        }

        $html .= '<div class="grand-total">Total: $' . number_format($grand_total, 2) . '</div>';


        return $html;
    }
}
