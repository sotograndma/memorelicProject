<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\ItemReview;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_item()
    {
        $customer = Customer::factory()->create();

        $item = Item::create([
            'customers_id' => $customer->id,
            'name' => 'Antique Vase',
            'description' => 'A rare Ming Dynasty vase.',
            'price' => 2500000,
            'status' => 'available',
            'image_path' => 'vase.jpg',
            'condition' => 'good',
            'min_order' => 1,
            'year_of_origin' => 1800,
            'material' => 'Porcelain',
            'height' => 30,
            'width' => 20,
            'weight' => 2.5,
            'region_of_origin' => 'China',
            'maker' => 'Unknown',
            'rarity_level' => 'rare',
            'authenticity_certificate' => true,
            'authenticity_certificate_images' => null,
            'restoration_info' => null,
            'provenance' => 'Old collection',
            'category' => 'Decor',
            'damage_notes' => null,
            'shipping_locations' => 'Indonesia',
            'shipping_cost' => 50000,
            'stock' => 3,
            'sold_count' => 1,
            'returns_package' => null,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Antique Vase',
            'price' => 2500000,
        ]);
    }

    /** @test */
    public function it_belongs_to_a_customer()
    {
        $customer = Customer::factory()->create();
        $item = Item::factory()->create(['customers_id' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $item->customer);
        $this->assertEquals($customer->id, $item->customer->id);
    }

    /** @test */
    public function it_has_many_transactions()
    {
        $item = Item::factory()->create();
        Transaction::factory()->count(3)->create(['item_id' => $item->id]);

        $this->assertCount(3, $item->transactions);
    }

    /** @test */
    public function it_has_many_reviews()
    {
        $item = Item::factory()->create();
        ItemReview::factory()->count(2)->create(['item_id' => $item->id]);

        $this->assertCount(2, $item->reviews);
    }
}
