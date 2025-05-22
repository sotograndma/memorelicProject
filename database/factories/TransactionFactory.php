<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Auction;
use App\Models\Item;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'customer_id' => User::factory(),
            'auction_id' => null,
            'item_id' => Item::factory(),
            'total_price' => 200000,
            'status' => 'processing',
            'payment_code' => strtoupper('INV' . $this->faker->unique()->numerify('#####')),
            'shipping_address' => $this->faker->address,
            'quantity' => 1,
        ];
    }
}
