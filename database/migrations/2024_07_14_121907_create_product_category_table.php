<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fk_id_product');
            $table->unsignedInteger('fk_id_category');
            $table->timestamps();

            $table->foreign('fk_id_product')->references('id_product')->on('product');
            $table->foreign('fk_id_category')->references('id_category')->on('category');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category');
    }
};
