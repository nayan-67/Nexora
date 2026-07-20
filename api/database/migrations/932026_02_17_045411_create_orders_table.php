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
            $table->unsignedInteger('order_number')->nullable()->default(0);
            $table->enum('order_status', ['1', '2','3'])->nullable()->default('1')->comment('1: Pending, 2: Complete, 3:Canceled');
            $table->enum('payment_status', ['0', '1', '2'])->nullable()->default('0')->comment('0: Pending, 1: Paid, 2: Refunded');
            $table->string('payment_mode', 100);
            $table->foreignId('billing_address_id')->constrained('order_address');
            $table->foreignId('shipping_address_id')->constrained('order_address');
            $table->decimal('total_price', 10, 2);
            $table->unsignedInteger('eco_tax')->default(0);
            $table->decimal('discount', 10, 2);
            $table->string('used_coupon',100)->nullable();
            $table->decimal('shipping', 10, 2);
            $table->timestamps();
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
