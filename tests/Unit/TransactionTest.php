<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Item;
use App\Models\Auction;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_transaction()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $transaction = Transaction::create([
            'customer_id' => $user->id,
            'item_id' => $item->id,
            'total_price' => 200000,
            'status' => 'processing',
            'payment_code' => 'INV12345',
            'shipping_address' => 'Jl. Mawar No. 123',
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('transactions', [
            'customer_id' => $user->id,
            'item_id' => $item->id,
            'total_price' => 200000,
            'status' => 'processing',
        ]);
    }

    /** @test */
    public function it_belongs_to_a_customer()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create(['customer_id' => $user->id]);

        $this->assertInstanceOf(User::class, $transaction->customer);
        $this->assertEquals($user->id, $transaction->customer->id);
    }

    /** @test */
    public function it_belongs_to_an_item()
    {
        $item = Item::factory()->create();
        $transaction = Transaction::factory()->create(['item_id' => $item->id]);

        $this->assertInstanceOf(Item::class, $transaction->item);
        $this->assertEquals($item->id, $transaction->item->id);
    }

    /** @test */
    public function it_belongs_to_an_auction()
    {
        $auction = Auction::factory()->create();
        $transaction = Transaction::factory()->create(['auction_id' => $auction->id]);

        $this->assertInstanceOf(Auction::class, $transaction->auction);
        $this->assertEquals($auction->id, $transaction->auction->id);
    }

    /** @test */
    public function it_can_check_if_transaction_is_for_auction()
    {
        $transactionAuction = Transaction::factory()->create([
            'auction_id' => Auction::factory()->create()->id,
            'item_id' => null,
        ]);

        $transactionItem = Transaction::factory()->create([
            'auction_id' => null,
            'item_id' => Item::factory()->create()->id,
        ]);

        $this->assertTrue($transactionAuction->isAuction());
        $this->assertFalse($transactionItem->isAuction());
    }
}
