<?php

namespace App\Features\Order\RenderServices;

use App\Core\Base\Builders\Table\ColumnBuilder;
use App\Core\Base\Builders\Table\ColumnItem;
use App\Core\Base\Builders\Table\TableBuilder;
use App\Core\Base\RenderData\BaseRenderService;
use App\Core\Constants\ComponentConstants;
use App\Core\Constants\Constants;
use App\Core\Interfaces\Features\RenderServiceInterface;
use App\Features\Order\Models\Order;

class OrderRenderService extends BaseRenderService implements RenderServiceInterface {
    use OrderConstantsTrait;

    public static function get_columns() : ColumnBuilder {
        $columns_builder = ColumnBuilder
            ::new()
            ->column_id()
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("user_render")
                    ->label("User")
                    ->component(ComponentConstants::component_badge)
            )
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("product_count_render")
                    ->label("Products")
                    ->component(ComponentConstants::component_badge)
            );

        return $columns_builder;
    }



    public static function get_table_builder(array $params = []) : TableBuilder {
        $permission = $params[Constants::key_permission];

        $query = Order::byUser();


        $table_builder = TableBuilder::query($query)
                                     ->add_columns(self::get_columns());

        $table_builder
            ->row_actions(fn($model) => OrderActions::get_row_actions_by_permission($permission, $model, $params))
            ->row_click_action(fn($model) => OrderActions::get_row_click_action_by_permission($permission, $model, $params));

        return $table_builder;
    }
}
