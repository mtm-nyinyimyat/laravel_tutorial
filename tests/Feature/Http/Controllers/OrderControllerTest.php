<?php

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot view orders', function () {
    $this->get(route('orders.index'))->assertRedirect(route('login'));
});

test('authenticated users can create an order with items', function () {
    $user = User::factory()->create();
    $itemA = Item::factory()->create(['price' => 10.00]);
    $itemB = Item::factory()->create(['price' => 5.50]);

    $response = $this->actingAs($user)->post(route('orders.store'), [
        'status' => 'pending',
        'items' => [
            ['item_id' => $itemA->id, 'quantity' => 2],
            ['item_id' => $itemB->id, 'quantity' => 1],
        ],
    ]);

    $order = Order::query()->whereBelongsTo($user)->first();

    expect($order)->not->toBeNull()
        ->and((float) $order->total)->toBe(25.50)
        ->and($order->orderItems)->toHaveCount(2);

    $response->assertRedirect(route('orders.index'));
});

test('users cannot view another users order', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $order = Order::factory()->for($owner)->create();

    $this->actingAs($other)
        ->get(route('orders.show', $order))
        ->assertForbidden();
});

test('authenticated users can update their order', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create(['price' => 8.00]);
    $order = Order::factory()->for($user)->create(['status' => 'pending', 'total' => 0]);

    $response = $this->actingAs($user)->put(route('orders.update', $order), [
        'status' => 'processing',
        'items' => [
            ['item_id' => $item->id, 'quantity' => 3],
        ],
    ]);

    $order->refresh();

    expect($order->status)->toBe('processing')
        ->and((float) $order->total)->toBe(24.00)
        ->and($order->orderItems)->toHaveCount(1);

    $response->assertRedirect(route('orders.show', $order));
});
