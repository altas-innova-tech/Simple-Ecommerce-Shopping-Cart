<?php

namespace App\Features\Product\RenderServices;

use App\Core\Constants\FeaturesConstants;
use App\Core\Constants\IconConstants;
use App\Features\Product\Controllers\ProductController;
use App\Features\Product\FormRequest\ProductFormRequest;
use App\Features\Product\Models\Product;
use Illuminate\Support\Str;

trait ProductConstantsTrait {
    const string feature = FeaturesConstants::product;


    public static function get_feature_name() : string {
        return self::feature;
    }



    public static function get_feature_icon() : string {
        return IconConstants::feature_product;
    }



    public static function get_model_class() : string {
        return Product::class;
    }



    public static function get_controller_class() : string {
        return ProductController::class;
    }



    public static function get_form_request_class() : string {
        return ProductFormRequest::class;
    }



    public static function get_render_service_class() : string {
        return ProductRenderService::class;
    }



    public static function get_action_class() : string {
        return ProductActions::class;
    }



    public static function get_title_page_class() : string {
        return ProductTitlePageService::class;
    }

    public static function model_label($pluriel = false) : string {
        $model_label = "Product";

        if ($pluriel) {
            return Str::plural($model_label);
        }

        return $model_label;
    }
}
