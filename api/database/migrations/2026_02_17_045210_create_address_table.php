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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('addr_name',100);
            $table->string('f_name',100);
            $table->string('l_name',100);
            $table->string('phone',13);
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city',100);
            $table->string('postcode',7);
            $table->string('country',100);
            $table->string('state',100);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_delete')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_address');
    }
};
