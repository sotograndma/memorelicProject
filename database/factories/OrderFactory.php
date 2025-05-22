<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Item;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'item_id' => Item::factory(),
            'shipment_id' => null, // bisa ditambahkan setelah shipment dibuat
            'payment_status' => 'paid',
            'total_price' => 150000,
            'payment_method' => 'transfer',
            'order_status' => 'processing',
        ];
    }
}
