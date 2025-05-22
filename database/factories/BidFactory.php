<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bid;
use App\Models\Customer;
use App\Models\Auction;

class BidFactory extends Factory
{
    protected $model = Bid::class;

    public function definition(): array
    {
        return [
            'auction_id' => Auction::factory(),
            'customer_id' => Customer::factory(),
            'bid_amount' => $this->faker->numberBetween(100000, 500000),
            'is_highest' => false,
        ];
    }
}
