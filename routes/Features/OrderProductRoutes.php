<?php

use App\Core\Constants\FeaturesConstants;
use App\Features\OrderProduct\Controllers\OrderProductController;
use Illuminate\Support\Facades\Route;


Route::name(FeaturesConstants::order_product . ".")
     ->prefix(Str::slug(FeaturesConstants::order_product))
     ->group(function () {
         Route::get("/", [OrderProductController::class, "list"])
              ->name("list");


         Route::get("/create", [OrderProductController::class, "create"])
              ->name("create");

         Route::post("/", [OrderProductController::class, "store"])
              ->name("store");

         Route::prefix("multi")
              ->group(function () {
                  Route::delete("/destroy", [OrderProductController::class, "destroy_multi"])
                       ->name("destroy_multi");
              });

         Route::prefix("{key}")
              ->group(function () {
                  Route::get("/", [OrderProductController::class, "view"])
                       ->name("view");


                  Route::get("/edit", [OrderProductController::class, "edit"])
                       ->name("edit");

                  Route::put("/", [OrderProductController::class, "update"])
                       ->name("update");

                  Route::delete("/", [OrderProductController::class, "destroy"])
                       ->name("destroy");
              });
     });


Route::get("/cart", [OrderProductController::class, "cart"])
     ->name("cart");



Route::post("/checkout", [OrderProductController::class, "checkout"])
     ->name("checkout");
