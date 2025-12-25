<?php

namespace App\Core\Base\RenderData;

use App\Core\Base\Model\BaseModel;
use App\Core\Constants\Constants;
use App\Core\Constants\PermissionConstants;

class BaseTitlePageService {
    public static function get_title_page_by_permission(string $permission, ?BaseModel $model, array $params = []) : string {
        $feature = $params[Constants::key_feature];


        switch ($permission) {
            case PermissionConstants::permission_list:
                return static::get_titre_page_list($feature, $params);
            case PermissionConstants::permission_create:
                return static::get_titre_page_create($feature, $model, $params);
            case PermissionConstants::permission_view:
                return static::get_titre_page_view($feature, $model, $params);
            case PermissionConstants::permission_edit:
                return static::get_titre_page_edit($feature, $model, $params);


            default:
                dd("get_title_page_by_permission : Unknown permission : {$permission}");
        }
    }



    public static function get_titre_page_list(string $feature, array $params = []) : string {
        $model_class = $params[Constants::key_model_class];
        $model_label = $model_class::model_label(true);

        return "$model_label";
    }





    public static function get_titre_page_create(string $feature, ?BaseModel $model, array $params = []) : string {
        $model_class = $params[Constants::key_model_class];
        $model_label = $model_class::model_label();

        return "New $model_label";
    }



    public static function get_titre_page_view(string $feature, ?BaseModel $model, array $params = []) : string {
        return $model->label();
    }



    public static function get_titre_page_edit(string $feature, ?BaseModel $model, array $params = []) : string {
        $model_label = $model->label();

        return "Edit $model_label";
    }
}
