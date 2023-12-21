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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wps_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('sku')->nullable();
            $table->bigInteger('ca_warehouse')->default(0);
            $table->bigInteger('ga_warehouse')->default(0);
            $table->bigInteger('id_warehouse')->default(0);
            $table->bigInteger('in_warehouse')->default(0);
            $table->bigInteger('pa_warehouse')->default(0);
            $table->bigInteger('pa2_warehouse')->default(0);
            $table->bigInteger('tx_warehouse')->default(0);
            $table->bigInteger('total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
