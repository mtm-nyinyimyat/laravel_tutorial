<?php

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an order belongs to a user and has many order items', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create();
    $items = Item::factory()->count(2)->create();

    foreach ($items as $item) {
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'item_id' => $item->id,
            'quantity' => 2,
            'unit_price' => $item->price,
        ]);
    }

    $order->refresh();

    expect($order->user->is($user))->toBeTrue()
        ->and($order->orderItems)->toHaveCount(2)
        ->and($order->items)->toHaveCount(2);
});
