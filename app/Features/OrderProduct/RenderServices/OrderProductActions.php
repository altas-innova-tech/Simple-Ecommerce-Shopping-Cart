<?php

namespace App\Features\OrderProduct\RenderServices;


use App\Core\Base\Action\BaseActions;
use App\Core\Base\Builders\Action\ActionBuilder;
use App\Core\Base\Builders\Action\ActionItem;
use App\Core\Base\Model\BaseModel;
use App\Core\Constants\ColorConstants;
use App\Core\Constants\IconConstants;
use App\Core\Constants\PermissionConstants;
use App\Core\Services\FeaturesService;
use App\Core\Services\MethodeServices;

class OrderProductActions extends BaseActions {
    use OrderProductConstantsTrait;


    public function get_actions_list(array $params = []) : ActionBuilder {
        if (is_admin()) {
            parent::get_actions_list($params);
        }

        return $this->get_action_checkout($params);
    }



    public function get_action_checkout(array $params = []) : ActionBuilder {
        if (!is_member_has_order_cart_with_products()) {
            return ActionBuilder::new();
        }

        return ActionBuilder
            ::new()
            ->add_item(
                ActionItem
                    ::new()
                    ->label("Checkout")
                    ->color(ColorConstants::green)
                    ->icon(IconConstants::check)
                    ->method(MethodeServices::POST)
                    ->route("checkout")
            );
    }

}
