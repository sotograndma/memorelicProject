<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Auction;
use App\Models\Customer;
use App\Models\Bid;
use App\Models\Transaction;
use Carbon\Carbon;

class AuctionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_auction()
    {
        $customer = Customer::factory()->create();

        $auction = Auction::create([
            'customers_id' => $customer->id,
            'name' => 'Vintage Clock',
            'description' => 'Old fashioned clock.',
            'image_path' => 'clock.jpg',
            'starting_bid' => 100000,
            'buy_now_price' => 500000,
            'minimum_increment' => 10000,
            'start_time' => now(),
            'end_time' => now()->addDays(2),
            'highest_bid' => 120000,
            'highest_bidder_id' => $customer->id,
            'status' => 'ongoing',
            'is_checkout_done' => false,
        ]);

        $this->assertDatabaseHas('auctions', [
            'name' => 'Vintage Clock',
            'highest_bid' => 120000,
        ]);
    }

    /** @test */
    public function it_belongs_to_owner_and_highest_bidder()
    {
        $owner = Customer::factory()->create();
        $auction = Auction::factory()->create([
            'customers_id' => $owner->id,
            'highest_bidder_id' => $owner->id,
        ]);

        $this->assertInstanceOf(Customer::class, $auction->owner);
        $this->assertInstanceOf(Customer::class, $auction->highestBidder);
        $this->assertEquals($owner->id, $auction->owner->id);
    }

    /** @test */
    public function it_has_many_bids()
    {
        $auction = Auction::factory()->create();
        Bid::factory()->count(3)->create(['auction_id' => $auction->id]);

        $this->assertCount(3, $auction->bids);
    }

    /** @test */
    public function it_has_one_transaction()
    {
        $auction = Auction::factory()->create();
        Transaction::factory()->create(['auction_id' => $auction->id]);

        $this->assertInstanceOf(Transaction::class, $auction->transaction);
    }

    /** @test */
    public function it_can_check_if_auction_ended()
    {
        $auction = Auction::factory()->create([
            'end_time' => now()->subMinute(),
        ]);

        $this->assertTrue($auction->isEnded());
    }

    /** @test */
    public function it_can_check_if_user_is_winner()
    {
        $customer = Customer::factory()->create();
        $auction = Auction::factory()->create([
            'highest_bidder_id' => $customer->id,
            'status' => 'completed',
        ]);

        $this->assertTrue($auction->isUserWinner($customer->id));
    }

    /** @test */
    public function it_can_be_bought_now()
    {
        $auction = Auction::factory()->create([
            'buy_now_price' => 300000,
            'highest_bid' => 300000,
        ]);

        $this->assertTrue($auction->canBuyNow());
    }

    /** @test */
    public function it_can_check_checkout_availability()
    {
        $customer = Customer::factory()->create();
        $auction = Auction::factory()->create([
            'highest_bidder_id' => $customer->id,
            'status' => 'completed',
            'is_checkout_done' => false,
        ]);

        $this->assertTrue($auction->canCheckout($customer->id));
    }

    /** @test */
    public function scope_active_only_returns_ongoing_auctions()
    {
        Auction::factory()->create([
            'status' => 'completed',
            'end_time' => now()->addDay(),
        ]);

        Auction::factory()->create([
            'status' => 'ongoing',
            'end_time' => now()->addDay(),
        ]);

        $activeAuctions = Auction::active()->get();
        $this->assertCount(1, $activeAuctions);
        $this->assertEquals('ongoing', $activeAuctions->first()->status);
    }
}
