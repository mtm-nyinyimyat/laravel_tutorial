<x-layouts.app
    :title="$item->name.' — '.config('app.name')"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Items', 'url' => route('items.index')],
        ['label' => $item->name],
    ]"
>
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">{{ $item->name }}</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                ${{ number_format($item->price, 2) }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a
                href="{{ route('items.edit', $item) }}"
                class="rounded-md border border-[#e3e3e0] px-3 py-1.5 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
            >
                Edit
            </a>
            <x-confirm-delete :action="route('items.destroy', $item)" message="Are you sure you want to delete this item?">
                <button
                    type="submit"
                    class="rounded-md border border-red-200 px-3 py-1.5 text-sm text-[#f53003] transition hover:border-[#f53003] dark:border-red-900 dark:text-[#FF4433]"
                >
                    Delete
                </button>
            </x-confirm-delete>
        </div>
    </div>

    @if ($item->description)
        <p class="mb-8 max-w-2xl text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
            {{ $item->description }}
        </p>
    @endif

    <h2 class="mb-3 text-lg font-semibold tracking-tight">Related orders</h2>
    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-[#e3e3e0] bg-[#f8f8f5] dark:border-[#3E3E3A] dark:bg-[#1D1D1B]">
                <tr>
                    <th class="px-4 py-3 font-medium">Order</th>
                    <th class="px-4 py-3 font-medium">Customer</th>
                    <th class="px-4 py-3 font-medium">Qty</th>
                    <th class="px-4 py-3 font-medium">Unit price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($item->orderItems as $orderItem)
                    <tr class="border-b border-[#e3e3e0] last:border-0 dark:border-[#3E3E3A]">
                        <td class="px-4 py-3">
                            <a href="{{ route('orders.show', $orderItem->order) }}" class="underline-offset-4 hover:underline">
                                #{{ $orderItem->order_id }}
                            </a>
                        </td>
                        <td class="px-4 py-3">{{ $orderItem->order->user->name }}</td>
                        <td class="px-4 py-3">{{ $orderItem->quantity }}</td>
                        <td class="px-4 py-3">${{ number_format($orderItem->unit_price, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                            This item has not been ordered yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
