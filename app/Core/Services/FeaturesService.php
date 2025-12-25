<?php

namespace App\Core\Services;

use App\Core\Constants\PermissionConstants;
use Illuminate\Http\RedirectResponse;

class FeaturesService {
    public static function get_route_name_by_feature(string $feature, string $permission) : string {
        return "$feature.$permission";
    }



    public static function get_route(string $feature, string $permission, array $params = []) : string {
        $route_name = self::get_route_name_by_feature($feature, $permission);

        return route($route_name, $params);
    }



    public static function redirect_to_list(string $feature, array $params = []) : RedirectResponse {
        $route_name = FeaturesService::get_route_name_by_feature($feature, PermissionConstants::permission_list);

        return to_route($route_name, $params);
    }

}
