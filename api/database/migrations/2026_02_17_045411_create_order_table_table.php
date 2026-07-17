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
        Schema::create('order_table', function (Blueprint $table) {
            $table->id();
            $table->string('user_id',100);
            $table->string('order_number',100)->nullable();
            $table->enum('order_status',['0','1','2','3'])->nullable()->default('1')->comment('0: Cancelled, 1: Processing, 2: Shipped, 3: Delivered');
            $table->enum('payment_status',['0','1','2'])->nullable()->default('1')->comment('0: Pending, 1: Paid, 2: Refunded');
            $table->string('payment_mode',100);
            $table->string('billing_address_id',100);
            $table->string('shipping_address_id',100);
            $table->string('total_price',100);
            $table->string('eco_tax',100);
            $table->string('discount',100);
            $table->string('shipping',100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_table');
    }
};
