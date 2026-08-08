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
        Schema::create('sub_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->boolean('status')->default(true)->comment('0: Inactive, 1: Active');
            // $table->boolean('is_delete')->default(false)->comment('0: Not Deleted, 1: Deleted');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_category');
    }
};
