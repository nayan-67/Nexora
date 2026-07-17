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
        Schema::create('discount', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->date('valid_from');
            $table->date('valid_till')->nullable();
            $table->enum('type', ['1', '2'])->comment('1: PERCENTAGE, 2: FIXED_AMOUNT');
            $table->decimal('amount', 10, 2);
            $table->boolean('status')->default(true)->comment('0: Inactive, 1: Active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount');
    }
};
