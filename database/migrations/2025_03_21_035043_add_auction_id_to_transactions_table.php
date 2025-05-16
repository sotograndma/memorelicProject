<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_id')->nullable()->after('customer_id');
            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade');

            // Ubah item_id menjadi nullable karena bisa dari item biasa atau auction
            $table->unsignedBigInteger('item_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Step 1: Drop FK auction_id jika kolom ada
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'auction_id')) {
                try {
                    // Pakai raw SQL untuk memastikan constraint hanya di-drop kalau benar-benar ada
                    DB::statement('ALTER TABLE transactions DROP FOREIGN KEY transactions_auction_id_foreign');
                } catch (\Throwable $e) {
                    // Optional: log or ignore
                }

                $table->dropColumn('auction_id');
            }
        });

        // Step 2: Kembalikan item_id jadi NOT NULL
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable(false)->change();
        });
    }
};
