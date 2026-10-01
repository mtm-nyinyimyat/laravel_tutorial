<?php

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot view items', function () {
    $this->get(route('items.index'))->assertRedirect(route('login'));
});

test('authenticated users can create an item', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('items.store'), [
        'name' => 'Notebook',
        'description' => 'A lined notebook',
        'price' => 9.99,
    ]);

    $item = Item::query()->where('name', 'Notebook')->first();

    expect($item)->not->toBeNull();
    $response->assertRedirect(route('items.index'));
    $this->assertDatabaseHas('items', [
        'name' => 'Notebook',
        'price' => 9.99,
    ]);
});

test('authenticated users can update an item', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create(['name' => 'Old name']);

    $response = $this->actingAs($user)->put(route('items.update', $item), [
        'name' => 'New name',
        'description' => 'Updated',
        'price' => 15.00,
    ]);

    $response->assertRedirect(route('items.show', $item));
    $this->assertDatabaseHas('items', [
        'id' => $item->id,
        'name' => 'New name',
        'price' => 15.00,
    ]);
});

test('items used in orders cannot be deleted', function () {
    $user = User::factory()->create();
    $item = Item::factory()->create();
    $order = Order::factory()->for($user)->create();

    $order->orderItems()->create([
        'item_id' => $item->id,
        'quantity' => 1,
        'unit_price' => $item->price,
    ]);

    $response = $this->actingAs($user)->delete(route('items.destroy', $item));

    $response->assertRedirect(route('items.index'));
    $this->assertDatabaseHas('items', ['id' => $item->id]);
});
