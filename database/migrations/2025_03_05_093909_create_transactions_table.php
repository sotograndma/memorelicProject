<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'waiting_payment', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('payment_code')->nullable();
            $table->text('shipping_address');

            $table->unsignedInteger('quantity')->default(1); // Jumlah yang dibeli

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
