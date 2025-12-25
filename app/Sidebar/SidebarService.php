<?php

namespace App\Sidebar;

use App\Core\Base\Builders\Navigation\NavigationBuilder;
use App\Core\Base\Builders\Navigation\NavigationItem;
use App\Core\Constants\Constants;
use App\Core\Constants\PermissionConstants;
use App\Core\Services\FeaturesService;
use App\Features\Product\Models\Product;

class SidebarService {
    public static function get_sidebar_content() : array {
        $models_permission = [
            Product::class
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
