<x-layouts.app
    :title="'Items — '.config('app.name')"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Items'],
    ]"
>
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Items</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Manage catalog items used in orders.</p>
        </div>
        <a
            href="{{ route('items.create') }}"
            class="rounded-md bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
        >
            New item
        </a>
    </div>

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-[#e3e3e0] bg-[#f8f8f5] dark:border-[#3E3E3A] dark:bg-[#1D1D1B]">
                <tr>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Price</th>
                    <th class="px-4 py-3 font-medium">Orders</th>
                    <th class="px-4 py-3 font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr class="border-b border-[#e3e3e0] last:border-0 dark:border-[#3E3E3A]">
                        <td class="px-4 py-3">
                            <a href="{{ route('items.show', $item) }}" class="font-medium underline-offset-4 hover:underline">
                                {{ $item->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3">${{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $item->order_items_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('items.show', $item) }}" class="text-[#706f6c] underline-offset-4 hover:underline dark:text-[#A1A09A]">
                                    View
                                </a>
                                <a href="{{ route('items.edit', $item) }}" class="text-[#706f6c] underline-offset-4 hover:underline dark:text-[#A1A09A]">
                                    Edit
                                </a>
                                <x-confirm-delete :action="route('items.destroy', $item)" message="Are you sure you want to delete this item?">
                                    <button
                                        type="submit"
                                        class="text-[#f53003] underline-offset-4 hover:underline dark:text-[#FF4433]"
                                    >
                                        Delete
                                    </button>
                                </x-confirm-delete>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                            No items yet. Create your first item.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</x-layouts.app>
