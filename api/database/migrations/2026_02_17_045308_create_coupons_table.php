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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code', 50)->unique();
            $table->text('description')->nullable();
            $table->date('valid_from');
            $table->date('valid_till')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1: Percentage, 2: Fixed_Amount');
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->decimal('minimum_order', 10, 2)->nullable();
            $table->unsignedInteger('usage_number')->nullable()->default(0);
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('usage_per_user')->nullable();
            $table->boolean('first_order_only')->default(false)->comment('0: No, 1: Yes');
            $table->boolean('status')->default(true)->comment('0: Inactive, 1: Active');

            $table->timestamps();
            $table->softDeletes();

            $table->index('coupon_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
