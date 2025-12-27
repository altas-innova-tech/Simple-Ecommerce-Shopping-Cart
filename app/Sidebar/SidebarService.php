<?php

namespace App\Sidebar;

use App\Core\Base\Builders\Navigation\NavigationBuilder;
use App\Core\Base\Builders\Navigation\NavigationItem;
use App\Core\Constants\Constants;
use App\Core\Constants\FeaturesConstants;
use App\Core\Constants\IconConstants;
use App\Core\Constants\PermissionConstants;
use App\Core\Services\FeaturesService;
use App\Features\Order\Models\Order;
use App\Features\Order\Services\OrderService;
use App\Features\OrderProduct\Models\OrderProduct;
use App\Features\Product\Models\Product;
use function PHPUnit\Framework\isReadable;

class SidebarService {
    public static function get_sidebar_content() : array {
        if (is_admin()) {
            return self::get_sidebar_content_admin();
        }

        return self::get_sidebar_content_member();
    }



    public static function get_sidebar_content_admin() {
        $sidebar_navigation = NavigationBuilder::new();


        $order_products_cart = Order::count();
        $products            = Product::count();


        $sidebar_navigation->add_item(
            NavigationItem
                ::new()
                ->label("Features")
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label("Products")
                        ->icon(Product::get_feature_icon())
                        ->url(FeaturesService::get_route(FeaturesConstants::product, PermissionConstants::permission_list))
                        ->badge($products)
                )
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label("Orders")
                        ->icon(OrderProduct::get_feature_icon())
                        ->url(FeaturesService::get_route(FeaturesConstants::order, PermissionConstants::permission_list))
                        ->badge($order_products_cart)
                )
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label("Horizon")
                        ->icon(IconConstants::FlipHorizontal2)
                        ->url('/horizon')
                )
        );

        return $sidebar_navigation->get();
    }



    public static function get_sidebar_content_member() {
        $sidebar_navigation = NavigationBuilder::new();


        $order_products_cart = Order::get_member_order_cart()
                                    ?->products()
                                    ->count();


        $orders_complete = Order::get_member_completed_orders()
                                ->count();


        $sidebar_navigation->add_item(
            NavigationItem
                ::new()
                ->label("Features")
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label("Products")
                        ->icon(Product::get_feature_icon())
                        ->url(FeaturesService::get_route(FeaturesConstants::product, PermissionConstants::permission_list))
                )
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label("My cart")
                        ->icon(OrderProduct::get_feature_icon())
                        ->url(route("cart"))
                        ->badge($order_products_cart)
                )
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label("My Orders")
                        ->icon(Order::get_feature_icon())
                        ->url(FeaturesService::get_route(FeaturesConstants::order, PermissionConstants::permission_list))
                        ->badge($orders_complete)
                )
        );

        return $sidebar_navigation->get();
    }



    public static function get_sidebar_content_2() : array {
        $models_permission = [
            Product::class,
            Order::class,
        ];


        $sidebar_navigation = NavigationBuilder::new();

        $features_nav_item = NavigationItem::new()
                                           ->label("Features");

        foreach ($models_permission as $model_class) {
            $feature                            = $model_class::get_feature_name();
            $title_page_class                   = $model_class::get_title_page_class();
            $params[Constants::key_model_class] = $model_class;

            $model_nav_item = NavigationItem
                ::new()
                ->label($model_class::model_label(true))
                ->icon($model_class::get_feature_icon())
                ->url(FeaturesService::get_route($feature, PermissionConstants::permission_list))
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label($title_page_class::get_titre_page_list($feature, $params))
                        ->url(FeaturesService::get_route($feature, PermissionConstants::permission_list))
                )
                ->add_item(
                    NavigationItem
                        ::new()
                        ->label($title_page_class::get_titre_page_create($feature, null, $params))
                        ->url(FeaturesService::get_route($feature, PermissionConstants::permission_create))
                );

            $features_nav_item->add_item($model_nav_item);
        }

        $sidebar_navigation->add_item($features_nav_item);

        return $sidebar_navigation->get();
    }

}
