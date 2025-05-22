<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Auction;
use App\Models\Customer;

class AuctionFactory extends Factory
{
    protected $model = Auction::class;

    public function definition(): array
    {
        return [
            'customers_id' => Customer::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'image_path' => 'default.jpg',
            'starting_bid' => 100000,
            'buy_now_price' => 500000,
            'minimum_increment' => 10000,
            'start_time' => now(),
            'end_time' => now()->addDays(3),
            'highest_bid' => 120000,
            'highest_bidder_id' => Customer::factory(),
            'status' => 'ongoing',
            'is_checkout_done' => false,
            'condition' => 'good',
            'year_of_origin' => 1950,
            'material' => 'metal',
            'height' => 15,
            'width' => 10,
            'weight' => 1.2,
            'region_of_origin' => 'Yogyakarta',
            'maker' => 'Pengrajin Lokal',
            'rarity_level' => 'rare',
            'authenticity_certificate' => true,
            'authenticity_certificate_images' => null,
            'restoration_info' => null,
            'provenance' => 'kolektor lama',
            'category' => 'antik',
            'damage_notes' => null,
            'shipping_locations' => 'Indonesia',
            'shipping_cost' => 40000,
            'returns_package' => null,
        ];
    }
}
