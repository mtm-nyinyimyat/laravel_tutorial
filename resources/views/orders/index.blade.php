<x-layouts.app
    :title="'Orders — '.config('app.name')"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Orders'],
    ]"
>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Orders</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Your orders and their line items.</p>
        </div>
        <a
            href="{{ route('orders.create') }}"
            class="inline-flex items-center gap-1.5 rounded-md bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
        >
            <x-icons.plus />
            New order
        </a>
    </div>

    <div class="mb-4">
        <x-search-form :action="route('orders.index')" placeholder="Search orders by ID, status, or item name..." />
    </div>

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-[#e3e3e0] bg-[#f8f8f5] dark:border-[#3E3E3A] dark:bg-[#1D1D1B]">
                <tr>
                    <th class="px-4 py-3 font-medium">Order</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Items</th>
                    <th class="px-4 py-3 font-medium">Total</th>
                    <th class="px-4 py-3 font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-b border-[#e3e3e0] last:border-0 dark:border-[#3E3E3A]">
                        <td class="px-4 py-3">
                            <a href="{{ route('orders.show', $order) }}" class="font-medium underline-offset-4 hover:underline">
                                #{{ $order->id }}
                            </a>
                        </td>
                        <td class="px-4 py-3 capitalize">{{ $order->status }}</td>
                        <td class="px-4 py-3">{{ $order->order_items_count }}</td>
                        <td class="px-4 py-3">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a
                                    href="{{ route('orders.show', $order) }}"
                                    class="inline-flex items-center gap-1.5 rounded-md border border-[#e3e3e0] px-3 py-1.5 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
                                >
                                    <x-icons.eye />
                                    View
                                </a>
                                <a
                                    href="{{ route('orders.edit', $order) }}"
                                    class="inline-flex items-center gap-1.5 rounded-md border border-[#e3e3e0] px-3 py-1.5 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
                                >
                                    <x-icons.pencil />
                                    Edit
                                </a>
                                <x-confirm-delete :action="route('orders.destroy', $order)" message="Are you sure you want to delete this order?">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-md border border-red-200 px-3 py-1.5 text-sm text-[#f53003] transition hover:border-[#f53003] dark:border-red-900 dark:text-[#FF4433]"
                                    >
                                        <x-icons.trash />
                                        Delete
                                    </button>
                                </x-confirm-delete>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                            No orders yet. Create your first order.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</x-layouts.app>
