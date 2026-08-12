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
            $table->tinyInteger('product_type')->unsigned()->comment('1: simple, 2: variant');
            $table->string('sku', 100);
            $table->unsignedInteger('quantity');
            $table->decimal('price', 10, 2);
            $table->dateTime('delivery_date')->nullable();
            $table->dateTime('request_date')->nullable()->comment('Return/Replacement Request Date');
            $table->dateTime('rr_date')->nullable()->comment('Return/Replacement Date');
            $table->dateTime('refund_date')->nullable()->comment('Refund Date');
            $table->tinyInteger('status')->unsigned()->default(0)->comment('1: Processing, 2: Shipped, 3: Out for Delivery, 4: Delivered, 5: Cancelled, 6: Return Requested, 7: Replacement Requested, 8: Returned, 9: Replaced, 10: Refund Requested, 11: Refund Initiated, 12: Refunded');

            $table->timestamps();
            $table->index(['user_id','order_id', 'product_id', 'sku']);
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
