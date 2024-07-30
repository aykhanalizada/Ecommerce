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
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('fk_id_media')->nullable();
            $table->boolean('is_admin')->default(0)->nullable();
            $table->rememberToken()->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->boolean('is_deleted')->default(0)->nullable();

            $table->foreign('fk_id_media')->references('id_media')->on('media');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
