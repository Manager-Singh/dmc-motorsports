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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wps_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->float('list_price')->nullable();
            $table->float('standard_dealer_price')->nullable();
            $table->string('supplier_product_id')->nullable();
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->string('upc')->nullable();
            $table->string('superseded_sku')->nullable();
            $table->string('status_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('unit_of_measurement_id')->nullable();
            $table->boolean('has_map_policy')->deault(false);
            $table->integer('sort')->default(0);
            $table->string('product_type')->nullable();
            $table->float('mapp_price')->nullable();
            $table->string('carb')->nullable(); 
            $table->string('propd1')->nullable(); 
            $table->string('propd2')->nullable();
            $table->string('prop_65_code')->nullable();
            $table->string('prop_65_detail')->nullable();
            $table->string('drop_ship_fee')->nullable();
            $table->boolean('drop_ship_eligible')->deault(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
