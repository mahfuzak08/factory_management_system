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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('order_type')->default('purchase');
            $table->integer('user_id');
            $table->integer('vendor_id');
            $table->json('products')->nullable();
            $table->json('return_items')->nullable();
            $table->date('date');
            $table->integer('status')->default(1);
            $table->string('discount_code')->nullable();
            $table->float('shipping_cost')->default(0);
            $table->float('labour_cost')->default(0);
            $table->float('carrying_cost')->default(0);
            $table->float('other_cost')->default(0);
            $table->float('total')->default(0);
            $table->float('asof_date_due')->default(0);
            $table->float('note')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
