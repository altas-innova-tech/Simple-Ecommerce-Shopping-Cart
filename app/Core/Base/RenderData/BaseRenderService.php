<?php

namespace App\Core\Base\RenderData;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\Constants;
use App\Core\Constants\PermissionConstants;

class BaseRenderService {
    public static function get_render_by_permission(string $permission, BaseModel $model = null, array $params = []) : array {
        $controller_class = static::get_controller_class();
        $model_class      = $controller_class::get_model_class();
        $action_class     = $controller_class::get_action_class();
        $title_page_class = $controller_class::get_title_page_class();


        $params                                    = [
            Constants::key_controller_class => $controller_class,
            Constants::key_action_class     => $action_class,
            Constants::key_title_page_class => $title_page_class,
            Constants::key_permission       => $permission,
            Constants::key_model            => $model ?? (new $model_class()),
            Constants::key_model_class      => $model_class,
            Constants::key_feature          => $controller_class::feature,
        ];
        $render_params[Constants::key_permission]  = $permission;
        $render_params[Constants::key_actions]     = $action_class::get_actions_by_permission($permission, $model, $params)
                                                                  ->get();
        $render_params[Constants::key_title_page]  = $title_page_class::get_title_page_by_permission($permission, $model, $params);
        $render_params[Constants::key_model]       = $model;

        if ($permission === PermissionConstants::permission_list) {
            $render_params[Constants::key_actions_multi] = $action_class::get_actions_multi_by_permission($permission, $params)
                                                                        ->get();

            $render_params[Constants::key_table_builder] = static::get_table_builder($params)
                                                                 ->get();
        }

        $commun_render_params = static::get_commun_render_params($render_params);
        $extra_render_params  = static::get_render_params_by_permission($render_params, $permission);


        return array_merge($render_params, $commun_render_params, $extra_render_params);
    }



    public static function get_render_params_by_permission(array $render_params, string $permission) : array {
        switch ($permission) {
            case PermissionConstants::permission_list:
                return static::get_render_params_list($render_params, $permission);
            case PermissionConstants::permission_create:
                return static::get_render_params_create($render_params, $permission);
            case PermissionConstants::permission_view:
                return static::get_render_params_view($render_params, $permission);
            case PermissionConstants::permission_edit:
                return static::get_render_params_edit($render_params, $permission);
            default:
                return $render_params;
        }
    }



    public static function get_render_params_list(array $render_params, string $permission) : array {
        return [];
    }



    public static function get_render_params_trashed(array $render_params, string $permission) : array {
        return [];
    }



    public static function get_render_params_create(array $render_params, string $permission) : array {
        return $render_params;
    }



    public static function get_render_params_view(array $render_params, string $permission) : array {
        return $render_params;
    }



    public static function get_render_params_edit(array $render_params, string $permission) : array {
        return $render_params;
    }



    public static function get_commun_render_params(array $render_params) : array {
        return $render_params;
    }
}
