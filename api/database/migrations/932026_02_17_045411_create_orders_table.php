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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('order_number', 100)->unique()->nullable();
            $table->tinyInteger('order_status')->nullable()->default(1)->comment('1: Pending, 2: Complete, 3:Canceled');
            $table->tinyInteger('payment_status')->nullable()->default(1)->comment('1: Pending, 2: Paid, 3: Refunded');
            $table->string('payment_mode', 100);
            $table->foreignId('billing_address_id')->constrained('order_address');
            $table->foreignId('shipping_address_id')->constrained('order_address');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('discount_value', 10, 2);
            $table->string('used_coupon', 100)->nullable();
            $table->decimal('shipping_fee', 10, 2);

            $table->timestamps();

            $table->index(['user_id', 'order_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
