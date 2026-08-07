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
            $table->dateTime('request_date')->nullable()->comment('Return/Replacement Request Date');
            $table->dateTime('rr_date')->nullable()->comment('Return/Replacement Date');
            $table->tinyInteger('status')->unsigned()->default(0)->comment('0: Processing, 1: Shipped, 2: Out for Delivery, 3: Delivered, 4: Cancelled, 5: Return Requested, 6: Replacement Requested, 7: Returned, 8: Replaced, 9: Refund Requested, 10: Refund Initiated, 11: Refunded');

            $table->timestamps();
            $table->index('user_id', 'order_id', 'product_id', 'sku');
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
