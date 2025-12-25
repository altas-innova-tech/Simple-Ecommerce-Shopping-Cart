<?php

namespace App\Features\OrderProduct\RenderServices;

use App\Core\Constants\FeaturesConstants;
use App\Core\Constants\IconConstants;
use App\Features\OrderProduct\Controllers\OrderProductController;
use App\Features\OrderProduct\FormRequest\OrderProductFormRequest;
use App\Features\OrderProduct\Models\OrderProduct;
use App\Features\Product\Controllers\ProductController;
use App\Features\Product\FormRequest\ProductFormRequest;
use App\Features\Product\Models\Product;
use App\Features\Product\RenderServices\ProductActions;
use App\Features\Product\RenderServices\ProductRenderService;
use App\Features\Product\RenderServices\ProductTitlePageService;
use Illuminate\Support\Str;

trait OrderProductConstantsTrait {
    const string feature = FeaturesConstants::product;



    public static function get_feature_name() : string {
        return self::feature;
    }



    public static function get_feature_icon() : string {
        return IconConstants::feature_order_product;
    }



    public static function get_model_class() : string {
        return OrderProduct::class;
    }



    public static function get_controller_class() : string {
        return OrderProductController::class;
    }



    public static function get_form_request_class() : string {
        return OrderProductFormRequest::class;
    }



    public static function get_render_service_class() : string {
        return OrderProductRenderService::class;
    }



    public static function get_action_class() : string {
        return OrderProductActions::class;
    }



    public static function get_title_page_class() : string {
        return OrderProductTitlePageService::class;
    }



    public static function model_label($pluriel = false) : string {
        $model_label = "Order Product";

        if ($pluriel) {
            return Str::plural($model_label);
        }

        return $model_label;
    }
}
