<?php

use App\Core\Constants\FeaturesConstants;
use App\Features\Order\Services\OrderService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void {
        Schema::create(FeaturesConstants::order, function (Blueprint $table) {
            $table->id();
            $table->uuid("key");
            $table->enum("status", OrderService::status)
                  ->default(OrderService::status_cart);
            $table->foreignId('user_id')
                  ->constrained(FeaturesConstants::users)
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down() : void {
        Schema::dropIfExists(FeaturesConstants::order);
    }
};
