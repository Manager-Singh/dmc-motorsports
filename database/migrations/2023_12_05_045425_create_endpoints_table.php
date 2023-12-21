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
        Schema::create('endpoints', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint');
            $table->text('include')->nullable();
            $table->string('api_token');
            $table->string('request_type')->default('get');
            $table->string('status')->default('Not Excuted');
            $table->string('prev')->nullable();
            $table->string('current')->nullable();
            $table->string('sync')->nullable();
            $table->string('table_name');
            $table->integer('per_page')->default(20);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endpoints');
    }
};
