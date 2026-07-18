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
            $table->string('order_number', 100)->nullable();
            $table->enum('order_status', ['1', '2'])->nullable()->default('1')->comment('1: Pending, 2: Complete');
            $table->enum('payment_status', ['0', '1', '2'])->nullable()->default('1')->comment('0: Pending, 1: Paid, 2: Refunded');
            $table->string('payment_mode', 100);
            $table->foreignId('billing_address_id')->constrained('order_address');
            $table->foreignId('shipping_address_id')->constrained('order_address');
            $table->decimal('total_price', 10, 2);
            $table->unsignedInteger('eco_tax')->default(0);
            $table->decimal('discount', 10, 2);
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
