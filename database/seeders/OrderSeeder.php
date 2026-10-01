<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first() ?? User::factory()->create();
        $items = Item::query()->get();

        if ($items->isEmpty()) {
            $items = Item::factory()->count(5)->create();
        }

        Order::factory()
            ->count(3)
            ->for($user)
            ->create()
            ->each(function (Order $order) use ($items): void {
                $selectedItems = $items->random(min(3, $items->count()));
                $total = 0;

                foreach ($selectedItems as $item) {
                    $quantity = fake()->numberBetween(1, 3);

                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'item_id' => $item->id,
                        'quantity' => $quantity,
                        'unit_price' => $item->price,
                    ]);

                    $total += $quantity * (float) $item->price;
                }

                $order->update(['total' => $total]);
            });
    }
}
