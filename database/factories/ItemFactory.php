<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\Customer;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'customers_id' => Customer::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(10000, 100000),
            'status' => 'available',
            'image_path' => 'default.jpg',
            'condition' => 'good',
            'min_order' => 1,
            'year_of_origin' => 1950,
            'material' => 'wood',
            'height' => 10,
            'width' => 10,
            'weight' => 2.5,
            'region_of_origin' => 'Indonesia',
            'maker' => 'Unknown',
            'rarity_level' => 'rare',
            'authenticity_certificate' => false,
            'authenticity_certificate_images' => null,
            'restoration_info' => null,
            'provenance' => 'private collection',
            'category' => 'antique',
            'damage_notes' => null,
            'shipping_locations' => 'Indonesia',
            'shipping_cost' => 50000,
            'stock' => 1,
            'sold_count' => 0,
            'returns_package' => null,
        ];
    }
}
