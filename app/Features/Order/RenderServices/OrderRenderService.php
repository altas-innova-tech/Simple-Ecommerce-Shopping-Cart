<?php

namespace App\Features\Order\RenderServices;

use App\Core\Base\Builders\Filter\FilterBuilder;
use App\Core\Base\Builders\Filter\FilterItem;
use App\Core\Base\Builders\Table\ColumnBuilder;
use App\Core\Base\Builders\Table\ColumnItem;
use App\Core\Base\Builders\Table\TableBuilder;
use App\Core\Base\RenderData\BaseRenderService;
use App\Core\Constants\ComponentConstants;
use App\Core\Constants\Constants;
use App\Core\Interfaces\Features\RenderServiceInterface;
use App\Features\Order\Models\Order;
use App\Features\Order\Services\OrderService;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class OrderRenderService extends BaseRenderService implements RenderServiceInterface {
    use OrderConstantsTrait;

    public static function get_filter_builder() : FilterBuilder {
        $filter_builder = FilterBuilder
            ::new()
            ->add_filter(
                FilterItem
                    ::new()
                    ->label("Status")
                    ->name("status")
                    ->values(OrderService::get_status_render())
            );


        if (is_admin()) {
            $members = User::Member()
                           ->listForSelect()
                           ->get()
                           ->toArray();

            $filter_builder->add_filter(
                FilterItem
                    ::new()
                    ->label("Member")
                    ->name("user_id")
                    ->values($members)
            );
        }


        return $filter_builder;
    }



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
            )
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("total_render")
                    ->label("Total")
                    ->component(ComponentConstants::component_number)
            )
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("status")
                    ->label("Status")
                    ->component(ComponentConstants::component_badge)
            );

        return $columns_builder;
    }



    public static function get_table_builder(array $params = []) : TableBuilder {
        $permission = $params[Constants::key_permission];

        $query = Order::query();

        if (is_member()) {
            $query = Order::get_member_completed_orders();
        }


        $table_builder = TableBuilder::query($query)
                                     ->add_columns(self::get_columns());


        if (is_admin()) {
            $table_builder->add_filters(self::get_filter_builder());
        }

        $table_builder
            ->row_actions(fn($model) => OrderActions::get_row_actions_by_permission($permission, $model, $params))
            ->row_click_action(fn($model) => OrderActions::get_row_click_action_by_permission($permission, $model, $params));

        return $table_builder;
    }



    public static function get_render_params_list(array $render_params, string $permission) : array {
        $render_params = parent::get_render_params_list($render_params, $permission);


        if (is_member()) {
            $render_params[Constants::title_page] = "My orders";
        }

        return $render_params;
    }



    public static function get_commun_render_params(array $render_params) : array {
        $render_params = parent::get_commun_render_params($render_params);

        $render_params['status'] = OrderService::get_status_render();

        return $render_params;
    }
}
