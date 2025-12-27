<?php

namespace App\Features\OrderProduct\RenderServices;

use App\Core\Base\Builders\Table\ColumnBuilder;
use App\Core\Base\Builders\Table\ColumnItem;
use App\Core\Base\Builders\Table\TableBuilder;
use App\Core\Base\Model\BaseModel;
use App\Core\Base\RenderData\BaseRenderService;
use App\Core\Constants\ComponentConstants;
use App\Core\Constants\Constants;
use App\Core\Constants\PermissionConstants;
use App\Core\Interfaces\Features\RenderServiceInterface;
use App\Features\Order\Models\Order;
use App\Features\OrderProduct\Models\OrderProduct;

class OrderProductRenderService extends BaseRenderService implements RenderServiceInterface {
    use OrderProductConstantsTrait;

    public static function get_columns() : ColumnBuilder {
        $columns_builder = ColumnBuilder
            ::new()
            ->column_id()
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("product_render")
                    ->label("Product")
                    ->component(ComponentConstants::component_text)
            )
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("price")
                    ->label("Price")
                    ->component(ComponentConstants::component_number)
                    ->searchable()
                    ->triable()
            )
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("quantity")
                    ->label("Quantity")
                    ->component(ComponentConstants::component_number)
                    ->searchable()
                    ->triable()
            );

        return $columns_builder;
    }



    public static function get_table_builder(array $params = []) : TableBuilder {
        $permission = $params[Constants::key_permission];

        if (is_member()) {
            $order = Order::get_member_order_cart();

            $query = OrderProduct::orderId($order?->id);
        } else {
            $query = OrderProduct::query();
        }


        $table_builder = TableBuilder::query($query)
                                     ->add_columns(self::get_columns());

        $table_builder
            ->row_actions(fn($model) => OrderProductActions::get_row_actions_by_permission($permission, $model, $params))
            ->row_click_action(fn($model) => OrderProductActions::get_row_click_action_by_permission($permission, $model, $params));

        return $table_builder;
    }



    public static function get_render_params_list(array $render_params, string $permission) : array {
        $render_params = parent::get_render_params_list($render_params, $permission);

        if (is_member()) {
            $total = Order::get_member_total_cart();

            $render_params[Constants::title_page] = "My cart - Total ($total)";
        }

        return $render_params;
    }
}
