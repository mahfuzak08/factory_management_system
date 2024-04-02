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
        if(! Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('barcode')->nullable();
                $table->string('name');
                $table->string('description')->nullable();
                $table->string('commonimg')->nullable();
                $table->string('has_sl')->default('no');
                $table->string('brand_name')->nullable();
                $table->string('tags')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
