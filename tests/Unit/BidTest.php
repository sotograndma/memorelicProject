<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Bid;
use App\Models\Customer;
use App\Models\Auction;

class BidTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_bid()
    {
        $customer = Customer::factory()->create();
        $auction = Auction::factory()->create();

        $bid = Bid::create([
            'auction_id' => $auction->id,
            'customer_id' => $customer->id,
            'bid_amount' => 150000,
            'is_highest' => true,
        ]);

        $this->assertDatabaseHas('bids', [
            'auction_id' => $auction->id,
            'customer_id' => $customer->id,
            'bid_amount' => 150000,
            'is_highest' => true,
        ]);
    }

    /** @test */
    public function it_belongs_to_an_auction()
    {
        $auction = Auction::factory()->create();
        $bid = Bid::factory()->create(['auction_id' => $auction->id]);

        $this->assertInstanceOf(Auction::class, $bid->auction);
        $this->assertEquals($auction->id, $bid->auction->id);
    }

    /** @test */
    public function it_belongs_to_a_customer()
    {
        $customer = Customer::factory()->create();
        $bid = Bid::factory()->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $bid->customer);
        $this->assertEquals($customer->id, $bid->customer->id);
    }
}
