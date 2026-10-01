<?php

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an order item belongs to an order and an item', function () {
    $order = Order::factory()->create();
    $item = Item::factory()->create(['price' => 12.50]);

    $orderItem = OrderItem::factory()->create([
        'order_id' => $order->id,
        'item_id' => $item->id,
        'quantity' => 3,
        'unit_price' => 12.50,
    ]);

    expect($orderItem->order->is($order))->toBeTrue()
        ->and($orderItem->item->is($item))->toBeTrue()
        ->and($orderItem->quantity)->toBe(3)
        ->and($orderItem->unit_price)->toBe('12.50');
});
