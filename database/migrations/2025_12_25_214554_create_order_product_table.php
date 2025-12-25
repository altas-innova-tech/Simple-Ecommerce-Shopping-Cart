<?php

use App\Core\Constants\FeaturesConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void {
        Schema::create(FeaturesConstants::order_product, function (Blueprint $table) {
            $table->id();
            $table->uuid("key");
            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->foreignId('order_id')
                  ->constrained(FeaturesConstants::order)
                  ->onDelete('cascade');
            $table->foreignId('product_id')
                  ->constrained(FeaturesConstants::product)
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down() : void {
        Schema::dropIfExists(FeaturesConstants::order_product);
    }
};
