<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Shipment;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_order()
    {
        $customer = Customer::factory()->create();
        $item = Item::factory()->create();

        $order = Order::create([
            'customer_id' => $customer->id,
            'item_id' => $item->id,
            'payment_status' => 'paid',
            'total_price' => 150000,
            'payment_method' => 'transfer',
            'order_status' => 'processing',
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id,
            'item_id' => $item->id,
            'total_price' => 150000,
            'order_status' => 'processing',
        ]);
    }

    /** @test */
    public function it_belongs_to_a_customer()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $order->customer);
        $this->assertEquals($customer->id, $order->customer->id);
    }

    /** @test */
    public function it_belongs_to_an_item()
    {
        $item = Item::factory()->create();
        $order = Order::factory()->create(['item_id' => $item->id]);

        $this->assertInstanceOf(Item::class, $order->item);
        $this->assertEquals($item->id, $order->item->id);
    }

    /** @test */
    public function it_has_one_shipment()
    {
        $order = Order::factory()->create();
        $shipment = Shipment::factory()->create(['order_id' => $order->id]);

        $this->assertInstanceOf(Shipment::class, $order->shipment);
        $this->assertEquals($shipment->id, $order->shipment->id);
    }
}
