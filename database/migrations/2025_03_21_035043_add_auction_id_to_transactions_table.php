<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['auction_id']);
            $table->dropColumn('auction_id');

            // Kembalikan item_id menjadi wajib jika rollback
            $table->unsignedBigInteger('item_id')->nullable(false)->change();
        });
    }
};
