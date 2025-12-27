<?php


namespace App\Features\OrderProduct\Services;


use App\Core\Base\Builders\Mail\MailBuilder;
use App\Core\Constants\FeaturesConstants;
use App\Core\Constants\PermissionConstants;
use App\Core\Services\FeaturesService;
use App\Features\Template\Services\TemplateService;
use App\Models\User;

class OrderProductService {
    public static function notify_admin_low_stock(array $params) : void {
        $order_product = $params['order_product'];
        $product       = $order_product->product;
        $quantity      = $product->stock_quantity;

        $admins = User::admin()
                      ->get();

        $route_name  = FeaturesService::get_route_name_by_feature(FeaturesConstants::product, PermissionConstants::permission_view);
        $product_url = route($route_name, [$product->key]);

        foreach ($admins as $admin) {
            MailBuilder::new()
                       ->set_from_owner()
                       ->recipient($admin->email, $admin->name)
                       ->subject('Low Stock Alert')
                           ->tag('product_name', $product->name)
                       ->tag('quantity', $quantity)
                       ->tag('product_url', $product_url)
                       ->template(TemplateService::low_stock_notification)
                       ->send();
        }
    }

}
