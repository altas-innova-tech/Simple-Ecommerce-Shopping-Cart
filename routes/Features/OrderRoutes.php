<?php

use App\Core\Constants\FeaturesConstants;
use App\Features\Order\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


Route::name(FeaturesConstants::order . ".")
     ->prefix(FeaturesConstants::order)
     ->group(function () {
         Route::get("/", [OrderController::class, "list"])
              ->name("list");


         Route::get("/create", [OrderController::class, "create"])
              ->name("create");

         Route::post("/", [OrderController::class, "store"])
              ->name("store");

         Route::prefix("multi")
              ->group(function () {
                  Route::delete("/destroy", [OrderController::class, "destroy_multi"])
                       ->name("destroy_multi");
              });

         Route::prefix("{key}")
              ->group(function () {
                  Route::get("/", [OrderController::class, "view"])
                       ->name("view");


                  Route::get("/edit", [OrderController::class, "edit"])
                       ->name("edit");

                  Route::put("/", [OrderController::class, "update"])
                       ->name("update");

                  Route::delete("/", [OrderController::class, "destroy"])
                       ->name("destroy");
              });
     });
