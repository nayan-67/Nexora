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
            $table->string('name', 100);
            $table->date('valid_from');
            $table->date('valid_till')->nullable();
            $table->enum('type', ['1', '2'])->comment('1: Percentage, 2: Fixed_Amount');
            $table->decimal('amount', 10);
            $table->boolean('status')->default(true)->comment('0: Inactive, 1: Active');
            $table->unsignedInteger('uses_number')->nullable()->default(0);
            $table->timestamps();
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
