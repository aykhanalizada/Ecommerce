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
        Schema::create('brand', function (Blueprint $table) {
            $table->increments('id_brand');
            $table->string('title')->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->boolean('is_deleted')->default(0)->nullable();
            $table->unsignedInteger('fk_id_media')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('fk_id_media')->references('id_media')->on('media');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand');
    }
};
