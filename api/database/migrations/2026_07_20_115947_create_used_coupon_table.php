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
        Schema::create('used_coupon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('order_number', 100);
            $table->string('coupon_code', 100);
            $table->tinyInteger('type')->comment('1: Percentage, 2: Fixed_Amount');
            $table->unsignedInteger('amount');

            $table->timestamps();

            $table->index(['user_id', 'order_number', 'coupon_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('used_coupon');
    }
};
