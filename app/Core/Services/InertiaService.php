<?php

namespace App\Core\Services;

use App\Core\Constants\PermissionConstants;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class InertiaService {
    public static function render_feature(string $feature, string $permission, array $params = []) : Response {
        $permission_item = [PermissionConstants::permission_edit, PermissionConstants::permission_create];

        if (in_array($permission, $permission_item)) {
            $permission = PermissionConstants::permission_view;
        }



        $feature_folder = Str::studly($feature);
        $file_name      = Str::slug($feature);

        $route_file = "Features/{$feature_folder}/{$file_name}-{$permission}";


        return Inertia::render(
            $route_file,
            $params
        );
    }



    public static function render(string $feature, string $mode_view, array $params = []) : Response {
        $mode_view_item = [PermissionConstants::permission_edit, PermissionConstants::permission_create];

        if (in_array($mode_view, $mode_view_item)) {
            $mode_view = PermissionConstants::permission_view;
        }

        $route_file = "Features/{$feature}/{$feature}-{$mode_view}";


        return Inertia::render(
            $route_file,
            $params
        );
    }



    public static function render_public(string $name, array $params = []) : Response {
        $route_file = "public/{$name}";


        return Inertia::render(
            $route_file,
            $params
        );
    }



    public static function render_custom(string $feature, string $name, array $params = []) : Response {
        $route_file = "Features/{$feature}/{$name}";

        return Inertia::render(
            $route_file,
            $params
        );
    }
}
