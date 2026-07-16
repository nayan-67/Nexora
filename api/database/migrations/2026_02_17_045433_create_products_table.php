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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->enum('type', ['1', '2'])->default('1')->comment('1 => simple, 2 => variable');
            $table->string('sku', 100)->unique()->nullable();
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->longText('description');
            $table->json('features')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->text('featured_image')->nullable();
            $table->json('gallery_image')->nullable()->default(null);
            $table->integer('stock')->nullable();
            $table->boolean('is_feature')->default(false)->comment('0 => no, 1 => yes');
            $table->boolean('is_delete')->default(false)->comment('0 => no, 1 => yes');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
