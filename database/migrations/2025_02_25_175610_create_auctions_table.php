<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            // Pemilik lelang (user yang melelang barang)
            $table->unsignedBigInteger('customers_id');
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');

            // Info barang
            $table->string('name');
            $table->text('description');
            $table->string('image_path')->nullable();

            // Harga & aturan lelang
            $table->decimal('starting_bid', 10, 2);
            $table->decimal('buy_now_price', 10, 2)->nullable(); // Harga langsung beli
            $table->decimal('minimum_increment', 10, 2)->default(5000); // Minimum bid berikutnya

            // Waktu lelang
            $table->timestamp('start_time');
            $table->timestamp('end_time');

            // Status bid
            $table->decimal('highest_bid', 10, 2)->default(0);
            $table->foreignId('highest_bidder_id')->nullable()->constrained('customers')->onDelete('set null');

            // Status lelang: ongoing = berjalan, ended = waktu habis, sold = berhasil dibeli
            $table->enum('status', ['ongoing', 'ended', 'sold'])->default('ongoing');

            // Menandai apakah barang sudah dibayar (checkout selesai)
            $table->boolean('is_checkout_done')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
