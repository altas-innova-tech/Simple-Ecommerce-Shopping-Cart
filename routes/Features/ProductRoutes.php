<?php

use App\Core\Constants\FeaturesConstants;
use App\Features\Product\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::name(FeaturesConstants::product . ".")
     ->prefix(FeaturesConstants::product)
     ->group(function () {
         Route::get("/", [ProductController::class, "list"])
              ->name("list");

         Route::get("/trashed", [ProductController::class, "trashed"])
              ->name("trashed");

         Route::get("/create", [ProductController::class, "create"])
              ->name("create");

         Route::post("/", [ProductController::class, "store"])
              ->name("store");

         Route::prefix("multi")
              ->group(function () {
                  Route::delete("/destroy", [ProductController::class, "destroy_multi"])
                       ->name("destroy_multi");
              });

         Route::prefix("{key}")
              ->group(function () {
                  Route::get("/", [ProductController::class, "view"])
                       ->name("view");


                  Route::get("/edit", [ProductController::class, "edit"])
                       ->name("edit");

                  Route::put("/", [ProductController::class, "update"])
                       ->name("update");

                  Route::delete("/", [ProductController::class, "destroy"])
                       ->name("destroy");
              });
     });
