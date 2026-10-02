<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $orders = Order::query()
            ->whereBelongsTo($request->user())
            ->with(['orderItems.item'])
            ->withCount('orderItems')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('status', 'like', "%{$search}%")
                        ->orWhere('id', $search)
                        ->orWhereHas('items', function ($query) use ($search): void {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', [
            'orders' => $orders,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $items = Item::query()->orderBy('name')->get();

        return view('orders.create', [
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $order = DB::transaction(function () use ($request): Order {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => $request->validated('status'),
                'total' => 0,
            ]);

            $this->syncOrderItems($order, $request->validated('items'));

            return $order->refresh();
        });

        return redirect()
            ->route('orders.index')
            ->with('status', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load(['orderItems.item', 'user']);

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load('orderItems');
        $items = Item::query()->orderBy('name')->get();

        return view('orders.edit', [
            'order' => $order,
            'items' => $items,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        DB::transaction(function () use ($request, $order): void {
            $order->update([
                'status' => $request->validated('status'),
            ]);

            $order->orderItems()->delete();
            $this->syncOrderItems($order, $request->validated('items'));
        });

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('status', 'Order deleted successfully.');
    }

    /**
     * @param  array<int, array{item_id: int, quantity: int}>  $selectedItems
     */
    private function syncOrderItems(Order $order, array $selectedItems): void
    {
        $catalogItems = Item::query()
            ->whereIn('id', collect($selectedItems)->pluck('item_id'))
            ->get()
            ->keyBy('id');

        $total = 0;

        foreach ($selectedItems as $selectedItem) {
            $item = $catalogItems->get($selectedItem['item_id']);

            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item->id,
                'quantity' => $selectedItem['quantity'],
                'unit_price' => $item->price,
            ]);

            $total += $selectedItem['quantity'] * (float) $item->price;
        }

        $order->update(['total' => $total]);
    }
}
