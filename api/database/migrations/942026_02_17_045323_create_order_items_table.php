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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('product_id')->constrained('products');
            $table->tinyInteger('product_type')->unsigned();
            $table->string('sku', 100);
            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2);
            $table->dateTime('delivery_date')->nullable();
            $table->dateTime('rr_date')->nullable()->comment('Return/Replacement Request Date');
            $table->enum('status', ['0', '1', '2', '3'])->nullable()->default('1')->comment('0: Cancelled, 1: Processing, 2: Shipped, 3: Delivered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
