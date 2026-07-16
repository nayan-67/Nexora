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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->unique();
            $table->string('slug',100)->unique();
            $table->text('description');
            $table->integer('order_number')->default(0);
            $table->text('image');
            $table->integer('total_products')->default(0)->nullable();
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
        Schema::dropIfExists('category');
    }
};
