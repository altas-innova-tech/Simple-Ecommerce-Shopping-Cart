<?php

namespace App\Core\Base\Traits;

use App\Core\Base\Builders\Action\ActionItem;
use App\Core\Base\Model\BaseModel;
use App\Core\Constants\ColorConstants;
use App\Core\Constants\Constants;
use App\Core\Constants\IconConstants;
use App\Core\Constants\PermissionConstants;
use App\Core\Services\FeaturesService;
use App\Core\Services\MethodeServices;

trait ActionItemMethodsTrait {

    public function action_create(array $params = []) : ActionItem {
        $route_name = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_create);

        return ActionItem
            ::new()
            ->label("Create")
            ->color(ColorConstants::green)
            ->icon(IconConstants::plus)
            ->route($route_name);
    }







    public function action_view(BaseModel $model, array $params = []) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_view);
        $route_params = [
            Constants::key => $model->key,
        ];

        return ActionItem
            ::new()
            ->label("View")
            ->type(Constants::button_type_ghost)
            ->color(ColorConstants::green)
            ->icon(IconConstants::eye)
            ->route($route_name, $route_params);
    }



    public function action_edit(BaseModel $model, array $params = []) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_edit);
        $route_params = [
            Constants::key => $model->key,
        ];


        return ActionItem
            ::new()
            ->label("Edit")
            ->type(Constants::button_type_ghost)
            ->color(ColorConstants::green)
            ->icon(IconConstants::pen)
            ->route($route_name, $route_params);
    }



    public function action_destroy(BaseModel $model, array $params = []) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_destroy);
        $route_params = [
            Constants::key => $model->key,
        ];


        return ActionItem
            ::new()
            ->label("Destroy")
            ->color(ColorConstants::red)
            ->type(Constants::button_type_ghost)
            ->button_confirme()
            ->button_confirme_destroy_label($model->label())
            ->button_confirme_destroy_description()
            ->icon(IconConstants::trash)
            ->method(MethodeServices::DELETE)
            ->route($route_name, $route_params);
    }



    public function action_export(BaseModel $model, array $params = []) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_export);
        $route_params = [
            Constants::key => $model->key,
        ];

        return ActionItem
            ::new()
            ->label("Export")
            ->type(Constants::button_type_ghost)
            ->color(ColorConstants::blue)
            ->icon(IconConstants::file_down)
            ->method(MethodeServices::GET)
            ->route($route_name, $route_params);
    }



    public function action_force_destroy(BaseModel $model, array $params = []) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_force_destroy);
        $route_params = [
            Constants::key => $model->key,
        ];

        return ActionItem
            ::new()
            ->label("Force destroy")
            ->color(ColorConstants::red)
            ->icon(IconConstants::bomb)
            ->type(Constants::button_type_ghost)
            ->button_confirme()
            ->button_confirme_force_destroy_label($model->label())
            ->button_confirme_force_destroy_description()
            ->method(MethodeServices::DELETE)
            ->route($route_name, $route_params);
    }



    public function action_restore(BaseModel $model, array $params = []) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_restore);
        $route_params = [
            Constants::key => $model->key,
        ];

        return ActionItem
            ::new()
            ->label("Restore")
            ->color(ColorConstants::blue)
            ->icon(IconConstants::archive_restore)
            ->button_confirme()
            ->button_confirme_destroy_label($model->label())
            ->method(MethodeServices::POST)
            ->route($route_name, $route_params);
    }



    public function action_destroy_multi(array $params = []) : ActionItem {
        $model_class = $params[Constants::key_model_class];
        $model_label = $model_class::model_label(true);
        $route_name  = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_destroy_multi);

        $route_params = [];

        return ActionItem
            ::new()
            ->label("Destroy Multi")
            ->color(ColorConstants::blue)
            ->icon(IconConstants::trash)
            ->button_confirme()
            ->button_confirme_destroy_multi_label($model_label)
            ->button_confirme_destroy_description()
            ->method(MethodeServices::DELETE)
            ->route($route_name, $route_params);
    }



    public function action_export_multi(array $params) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_export_multi);
        $route_params = [];


        return ActionItem
            ::new()
            ->label("Export Multi")
            ->color(ColorConstants::blue)
            ->icon(IconConstants::file_down)
            ->method(MethodeServices::DELETE)
            ->route($route_name, $route_params);
    }



    public function action_force_destroy_multi(array $params) : ActionItem {
        $model_class = $params[Constants::key_model_class];
        $model_label = $model_class::model_label(true);
        $route_name  = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_force_destroy_multi);

        $route_params = [];


        return ActionItem
            ::new()
            ->label("Force destroy Multi")
            ->color(ColorConstants::blue)
            ->icon(IconConstants::bomb)
            ->button_confirme()
            ->button_confirme_force_destroy_multi_label($model_label)
            ->button_confirme_force_destroy_description()
            ->method(MethodeServices::DELETE)
            ->route($route_name, $route_params);
    }



    public function action_restore_multi(array $params) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_restore_multi);
        $model_class  = $params[Constants::key_model_class];
        $model_label  = $model_class::model_label(true);
        $route_params = [];


        return ActionItem
            ::new()
            ->label("Restore Multi")
            ->color(ColorConstants::blue)
            ->icon(IconConstants::archive_restore)
            ->button_confirme()
            ->button_confirme_restore_multi_label($model_label)
            ->method(MethodeServices::POST)
            ->route($route_name, $route_params);
    }



    public function action_back_to_list(BaseModel $model = null, array $params = []) : ActionItem {
        $route_name = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_list);

        return ActionItem
            ::new()
            ->label("Back to list")
            ->color(ColorConstants::gray)
            ->icon(IconConstants::move_left)
            ->route($route_name);
    }



    public function action_list(array $params = []) : ActionItem {
        $route_name = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_list);

        return ActionItem
            ::new()
            ->label("List")
            ->color(ColorConstants::green)
            ->icon(IconConstants::list_check)
            ->route($route_name);
    }



    public function action_store(BaseModel $model = null, array $params = []) : ActionItem {
        $route_name = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_store);

        return ActionItem
            ::new()
            ->label("Store")
            ->color(ColorConstants::green)
            ->icon(IconConstants::check)
            ->method(MethodeServices::POST)
            ->permission(PermissionConstants::permission_store)
            ->route($route_name);
    }



    public function action_update(BaseModel $model, array $params = []) : ActionItem {
        $route_name   = FeaturesService::get_route_name_by_feature(static::feature, PermissionConstants::permission_update);
        $route_params = [
            Constants::key => $model->key,
        ];

        return ActionItem
            ::new()
            ->label("Update")
            ->color(ColorConstants::green)
            ->icon(IconConstants::check)
            ->method(MethodeServices::PUT)
            ->permission(PermissionConstants::permission_update)
            ->route($route_name, $route_params);
    }

}
