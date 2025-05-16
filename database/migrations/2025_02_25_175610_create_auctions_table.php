<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customers_id');
            $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
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

            // Fields tambahan
            $table->enum('condition', ['Used', 'Excellent', 'Brand New', 'Restored'])->nullable(); // Condition: Used – Excellent, Brand New, etc.
            $table->timestamp('year_of_origin')->nullable(); // Tahun Pembuatan
            $table->string('material')->nullable(); // Material
            $table->string('height')->nullable(); // Dimensions (e.g., Height: 30 cm, Width: 15 cm)
            $table->string('width')->nullable(); // Dimensions (e.g., Height: 30 cm, Width: 15 cm)
            $table->decimal('weight', 8, 2)->nullable(); // Weight in kg
            $table->string('region_of_origin')->nullable(); // Region / Country of Origin
            $table->string('maker')->nullable(); // Maker / Artist / Manufacturer
            $table->enum('rarity_level', ['Common', 'Rare', 'Very Rare'])->nullable(); // Rarity Level
            $table->enum('authenticity_certificate', ['Yes', 'No', 'Under verification'])->nullable(); // Sertifikat Keaslian
            $table->string('authenticity_certificate_images')->nullable();
            $table->string('restoration_info')->nullable(); // Info Restorasi
            $table->text('provenance')->nullable(); // Provenance / Riwayat Kepemilikan
            $table->enum('category', ['Collectibles', 'Accessories', 'Traditional Weapons', 'Electronics', 'Furniture'])->nullable(); // Kategori
            $table->text('damage_notes')->nullable(); // Catatan kerusakan
            
            // Pengiriman
            $table->text('shipping_locations')->nullable(); // Lokasi pengiriman (free form)
            $table->enum('shipping_cost', [
                'Regular Shipping (0–1 kg) | from Rp6.500 | ETA: 2–3 days',
                'Medium Package (1–3 kg) | from Rp12.000 | ETA: 2–4 days',
                'Heavy Shipping (3–5 kg) | from Rp20.000 | ETA: 3–5 days'
            ])->nullable();

            $table->enum('returns_package', ['30-Day Refund / Replacement', '7-Day Refund Only', 'No Return / Final Sale'])->nullable(); // Return policy

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
