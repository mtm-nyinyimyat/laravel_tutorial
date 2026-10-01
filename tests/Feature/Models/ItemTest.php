<?php

use App\Models\Item;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an item can have many order items', function () {
    $item = Item::factory()->create();
    $orderItems = OrderItem::factory()->count(2)->for($item)->create();

    expect($item->orderItems)->toHaveCount(2)
        ->and($item->orderItems->pluck('id')->sort()->values()->all())
        ->toEqual($orderItems->pluck('id')->sort()->values()->all());
});
