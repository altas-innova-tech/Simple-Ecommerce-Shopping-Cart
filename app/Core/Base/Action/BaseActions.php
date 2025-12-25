<?php

namespace App\Core\Base\Action;

use App\Core\Base\Builders\Action\ActionBuilder;
use App\Core\Base\Model\BaseModel;
use App\Core\Base\Traits\ActionItemMethodsTrait;
use App\Core\Constants\PermissionConstants;
use App\Core\Traits\Actions\CrudActionTrait;

class BaseActions {
    use CrudActionTrait;
    use ActionItemMethodsTrait;

    public static function get_actions_by_permission(string $permission, BaseModel $model = null, array $params = []) : ActionBuilder {
        switch ($permission) {
            case PermissionConstants::permission_list:
                return (new static())->get_actions_list($params);
            case PermissionConstants::permission_create:
                return (new static())->get_actions_create($model, $params);
            case PermissionConstants::permission_view:
                return (new static())->get_actions_view($model, $params);
            case PermissionConstants::permission_edit:
                return (new static())->get_actions_edit($model, $params);


            default:
                dd("get_actions_by_permission : Unknown permission : {$permission}");
        }
    }



    public static function get_actions_multi_by_permission(string $permission, array $params) : ActionBuilder {
        switch ($permission) {
            case PermissionConstants::permission_list:
                return (new static())->get_actions_multi_list($params);


            default:
                dd("get_actions_multi_by_permission : Unknown permission : {$permission}");
        }
    }



    public static function get_row_actions_by_permission(string $permission, BaseModel $model, array $params) : ActionBuilder {
        switch ($permission) {
            case PermissionConstants::permission_list:
                return (new static())->get_row_actions_list($model, $params);


            default:
                return ActionBuilder::new();
        }
    }



    public static function get_row_click_action_by_permission(string $permission, BaseModel $model, array $params) : ActionBuilder {
        switch ($permission) {
            case PermissionConstants::permission_list:
                return (new static())->get_row_click_action_list($model, $params);


            default:
                return ActionBuilder::new();
        }
    }

}
