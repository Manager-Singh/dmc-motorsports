<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehiclemodel_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('vehiclemodel_id')->nullable();
            $table->timestamps();
            // $table->foreign('category_id')->references('wps_id')->on('categories')->onDelete('cascade');
            // $table->foreign('vehiclemodel_id')->references('wps_id')->on('vehiclemodels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiclemodel_categories');
    }
};
