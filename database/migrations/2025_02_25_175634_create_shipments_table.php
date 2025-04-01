<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->unique();
            $table->string('tracking_number')->unique()->nullable();
            $table->enum('order_status', ['processing', 'shipped', 'delivered', 'cancelled'])->default('processing');
            $table->timestamp('estimated_arrival')->nullable();
            $table->timestamps();
        });

        // **Trigger untuk otomatis update orders.order_status saat shipment berubah**
        DB::unprepared('
            CREATE TRIGGER update_order_status_after_shipment
            AFTER UPDATE ON shipments
            FOR EACH ROW
            BEGIN
                UPDATE orders 
                SET order_status = NEW.order_status
                WHERE id = NEW.order_id;
            END;
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');

        // Drop trigger jika migration di-rollback
        DB::unprepared('DROP TRIGGER IF EXISTS update_order_status_after_shipment');
    }
};
