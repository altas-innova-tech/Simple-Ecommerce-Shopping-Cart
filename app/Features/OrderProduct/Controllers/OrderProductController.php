<?php

namespace App\Features\OrderProduct\Controllers;

use App\Core\Base\Controller\BaseController;
use App\Core\Constants\PermissionConstants;
use App\Core\Services\FeaturesService;
use App\Core\Services\InertiaService;
use App\Core\Services\NotificationService;
use App\Core\Traits\Features\CrudTrait;
use App\Features\Order\Models\Order;
use App\Features\Order\Services\OrderService;
use App\Features\OrderProduct\Models\OrderProduct;
use App\Features\OrderProduct\RenderServices\OrderProductConstantsTrait;
use App\Features\OrderProduct\RenderServices\OrderProductRenderService;
use App\Features\Product\RenderServices\ProductConstantsTrait;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class OrderProductController extends BaseController {
    use CrudTrait;
    use OrderProductConstantsTrait;


    public function store() : RedirectResponse {
        //==============================================================================================================
        // Get needed classes for every feature
        //==============================================================================================================
        $feature            = static::feature;
        $permission         = PermissionConstants::permission_store;
        $model_class        = static::get_model_class();
        $form_request_class = static::get_form_request_class();


        //==============================================================================================================
        // Authorization
        //==============================================================================================================


        //==================================================================================================================
        // Validate attributes
        //==================================================================================================================
        $validated_attributes = app($form_request_class)->validated();

        //==================================================================================================================
        // Get active order cart or create new one
        //==================================================================================================================
        $order_active_cart                = OrderService::get_member_order_active_cart();
        $order_id                         = $order_active_cart->id;
        $validated_attributes['order_id'] = $order_id;
        $product_id                       = $validated_attributes["product_id"];

        $order_product_active = OrderProduct::where("product_id", $product_id)
                                            ->where("order_id", $order_id)
                                            ->first();

        if ($order_product_active) {
            $order_product_active->increment('quantity', $validated_attributes['quantity']);
            $order_product_active->save();

            $label = $order_product_active->label();
            NotificationService::success("$label Added to cart successfully !");

            return redirect()->back();
        }

        //==================================================================================================================
        // Create new instance
        //==================================================================================================================
        $model = new $model_class();


        //==================================================================================================================
        // Make dataService filable of modal
        //==================================================================================================================
        $model->fillable(array_keys($validated_attributes));
        $model->fill($validated_attributes);


        //==================================================================================================================
        // Check if model created successfully
        //==================================================================================================================
        if (!$model->save()) {
            NotificationService::error("$feature not saved");
        }


        //==============================================================================================================
        // Register actions
        //==============================================================================================================


        //==============================================================================================================
        // Render view
        //==============================================================================================================
        $label = $model->label();

        NotificationService::success("$label created successfully !");

        return redirect()->back();
    }



    public function cart(...$params) : RedirectResponse|Response {
        return static::list($params);
    }



    public function checkout(...$params) : RedirectResponse|Response {
        //==============================================================================================================
        // Get needed classes for every feature
        //==============================================================================================================
        $feature = static::feature;


        $order_cart = Order::get_member_order_cart();

        if (!$order_cart) {
            return NotificationService::error_to_list($feature, "No order cart found");
        }


        $order_cart->status = OrderService::status_completed;


        if (!$order_cart->save()) {
            return NotificationService::error_to_list($feature, "Order cart not saved");
        }


        NotificationService::success("Order checkout successfully !");

        return redirect()->back();
    }
}
