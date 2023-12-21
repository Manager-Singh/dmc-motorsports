<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->string('title');
            // $table->string('slug')->unique();
            // $table->text('summary');
            // $table->longText('description')->nullable();
            // $table->text('photo');
            // $table->integer('stock')->default(1);
            // $table->string('size')->default('M')->nullable();
            // $table->enum('condition',['default','new','hot'])->default('default');
            // $table->enum('status',['active','inactive'])->default('inactive');
            // $table->float('price');
            // $table->float('discount')->nullabale();
            // $table->boolean('is_featured')->deault(false);
            // $table->unsignedBigInteger('cat_id')->nullable();
            // $table->unsignedBigInteger('child_cat_id')->nullable();
            // $table->unsignedBigInteger('brand_id')->nullable();
            // $table->foreign('brand_id')->references('id')->on('brands')->onDelete('SET NULL');
            // $table->foreign('cat_id')->references('id')->on('categories')->onDelete('SET NULL');
            // $table->foreign('child_cat_id')->references('id')->on('categories')->onDelete('SET NULL');
            
            $table->unsignedBigInteger('wps_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('alternate_name')->nullable();
            $table->longText('care_instructions')->nullable();
            $table->longText('description')->nullable();
            $table->integer('sort')->default(0);
            $table->enum('status',['active','inactive'])->default('active');
            $table->text('image_360_id')->nullable();
            $table->text('image_360_preview_id')->nullable();
            $table->unsignedBigInteger('size_chart_id')->nullable();
            $table->boolean('is_featured')->deault(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
