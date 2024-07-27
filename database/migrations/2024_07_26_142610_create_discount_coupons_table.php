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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('max_uses_user')->nullable();
            $table->enum('type', ['fixed', 'percent'])->default('fixed');
            $table->double('discount_amount', 10, 2);
            $table->double('min_amount', 10, 2);
            $table->integer('status')->default(1);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_controllers');
    }
};