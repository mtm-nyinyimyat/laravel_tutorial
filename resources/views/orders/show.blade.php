<x-layouts.app :title="'Order #'.$order->id.' — '.config('app.name')">
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Order #{{ $order->id }}</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Status: <span class="capitalize">{{ $order->status }}</span>
                · Total ${{ number_format($order->total, 2) }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a
                href="{{ route('orders.edit', $order) }}"
                class="rounded-md border border-[#e3e3e0] px-3 py-1.5 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
            >
                Edit
            </a>
            <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Delete this order?')">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="rounded-md border border-red-200 px-3 py-1.5 text-sm text-[#f53003] transition hover:border-[#f53003] dark:border-red-900 dark:text-[#FF4433]"
                >
                    Delete
                </button>
            </form>
        </div>
    </div>

    <h2 class="mb-3 text-lg font-semibold tracking-tight">Line items</h2>
    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-[#e3e3e0] bg-[#f8f8f5] dark:border-[#3E3E3A] dark:bg-[#1D1D1B]">
                <tr>
                    <th class="px-4 py-3 font-medium">Item</th>
                    <th class="px-4 py-3 font-medium">Qty</th>
                    <th class="px-4 py-3 font-medium">Unit price</th>
                    <th class="px-4 py-3 font-medium">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $orderItem)
                    <tr class="border-b border-[#e3e3e0] last:border-0 dark:border-[#3E3E3A]">
                        <td class="px-4 py-3">
                            <a href="{{ route('items.show', $orderItem->item) }}" class="underline-offset-4 hover:underline">
                                {{ $orderItem->item->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3">{{ $orderItem->quantity }}</td>
                        <td class="px-4 py-3">${{ number_format($orderItem->unit_price, 2) }}</td>
                        <td class="px-4 py-3">${{ number_format($orderItem->quantity * $orderItem->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
