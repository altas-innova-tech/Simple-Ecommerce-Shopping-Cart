<?php

namespace App\Features\Product\RenderServices;


use App\Core\Base\Action\BaseActions;
use App\Core\Base\Builders\Action\ActionBuilder;
use App\Core\Base\Builders\Action\ActionItem;
use App\Core\Base\Model\BaseModel;
use App\Core\Constants\ColorConstants;
use App\Core\Constants\Constants;
use App\Core\Constants\FeaturesConstants;
use App\Core\Constants\IconConstants;
use App\Core\Constants\PermissionConstants;
use App\Core\Services\FeaturesService;
use App\Core\Services\MethodeServices;

class ProductActions extends BaseActions {
    use ProductConstantsTrait;

    public function get_actions_list(array $params = []) : ActionBuilder {
        if (is_admin()) {
            return parent::get_actions_list($params);
        }

        return ActionBuilder
            ::new();
    }



    public function get_row_actions_list(BaseModel $model, array $params = []) : ActionBuilder {
        if (is_admin()) {
            return parent::get_row_actions_list($model, $params);
        }


        if ($model->stock_quantity === 0) {
            return ActionBuilder
                ::new();
        }


        return $this->get_row_actions_list_member($model, $params);
    }



    public function get_row_actions_list_member(BaseModel $model, array $params = []) : ActionBuilder {
        $route_name  = FeaturesService::get_route_name_by_feature(FeaturesConstants::order_product, PermissionConstants::permission_store);

        return ActionBuilder
            ::new()
            ->add_item(
                ActionItem
                    ::new()
                    ->label("Add to cart")
                    ->color(ColorConstants::red)
                    ->type(Constants::button_type_destructive)
                    ->button_confirme()
                    ->model($model)
                    ->button_add_to_cart()
                    ->button_confirme_destroy_label(" ", "Add to your cart")
                    ->icon(IconConstants::ShoppingBasket)
                    ->method(MethodeServices::POST)
                    ->route($route_name)
            );
    }

}
