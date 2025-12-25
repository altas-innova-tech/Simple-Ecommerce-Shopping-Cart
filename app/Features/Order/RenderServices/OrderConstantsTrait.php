<?php

namespace App\Features\Order\RenderServices;

use App\Core\Constants\FeaturesConstants;
use App\Core\Constants\IconConstants;
use App\Features\Order\Controllers\OrderController;
use App\Features\Order\FormRequest\OrderFormRequest;
use App\Features\Order\Models\Order;
use Illuminate\Support\Str;

trait OrderConstantsTrait {
    const string feature = FeaturesConstants::order;



    public static function get_feature_name() : string {
        return self::feature;
    }



    public static function get_feature_icon() : string {
        return IconConstants::feature_order;
    }



    public static function get_model_class() : string {
        return Order::class;
    }



    public static function get_controller_class() : string {
        return OrderController::class;
    }



    public static function get_form_request_class() : string {
        return OrderFormRequest::class;
    }



    public static function get_render_service_class() : string {
        return OrderRenderService::class;
    }



    public static function get_action_class() : string {
        return OrderActions::class;
    }



    public static function get_title_page_class() : string {
        return OrderTitlePageService::class;
    }



    public static function model_label($pluriel = false) : string {
        $model_label = "Order";

        if ($pluriel) {
            return Str::plural($model_label);
        }

        return $model_label;
    }
}
