<?php

namespace App\Features\Product\RenderServices;

use App\Core\Base\Builders\Table\ColumnBuilder;
use App\Core\Base\Builders\Table\ColumnItem;
use App\Core\Base\Builders\Table\TableBuilder;
use App\Core\Base\RenderData\BaseRenderService;
use App\Core\Constants\ComponentConstants;
use App\Core\Constants\Constants;
use App\Core\Interfaces\Features\RenderServiceInterface;
use App\Features\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRenderService extends BaseRenderService implements RenderServiceInterface {
    use ProductConstantsTrait;

    public static function get_columns() : ColumnBuilder {
        $columns_builder = ColumnBuilder
            ::new()
            ->column_id()
            ->add_column(
                ColumnItem
                    ::new()
                    ->name("name")
                    ->label("Name")
                    ->component(ComponentConstants::component_text)
                    ->searchable()
                    ->triable()
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
                    ->name("stock_quantity")
                    ->label("Stock quantity")
                    ->component(ComponentConstants::component_number)
                    ->searchable()
                    ->triable()
            );


        //==============================================================================================================
        // Add column to display products status In/Out of stock
        //==============================================================================================================
        if (is_admin()) {
            $columns_builder->add_column(
                ColumnItem
                    ::new()
                    ->name("Statut")
                    ->label("status_render")
                    ->component(ComponentConstants::component_badge)
            );
        }

        return $columns_builder;
    }



    public static function get_table_builder(array $params = []) : TableBuilder {
        $permission = $params[Constants::key_permission];

        $query = Product::query()
                        ->when(is_member(), fn(Builder $query) => $query->inStock());

        $table_builder = TableBuilder::query($query)
                                     ->add_columns(self::get_columns());

        $table_builder
            ->row_actions(fn($model) => ProductActions::get_row_actions_by_permission($permission, $model, $params))
            ->row_click_action(fn($model) => ProductActions::get_row_click_action_by_permission($permission, $model, $params));

        return $table_builder;
    }



    public static function get_render_params_list(array $render_params, string $permission) : array {
        $render_params = parent::get_render_params_list($render_params, $permission);

        $render_params['display_checkbox'] = is_admin();


        return $render_params;
    }
}
