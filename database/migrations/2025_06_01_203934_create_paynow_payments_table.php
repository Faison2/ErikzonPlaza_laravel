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
        Schema::create('paynow_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('amount', 10, 2);
            $table->string('reference')->unique();
            $table->string('poll_url')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('paynow_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paynow_payments');
    }
};
