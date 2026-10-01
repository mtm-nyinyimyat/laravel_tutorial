<x-layouts.app :title="'New order — '.config('app.name')">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">New order</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Add items and quantities for this order.</p>
    </div>

    <x-order-form :action="route('orders.store')" :items="$items" submit="Create order">
        <a href="{{ route('orders.index') }}" class="text-sm text-[#706f6c] underline-offset-4 hover:underline dark:text-[#A1A09A]">
            Cancel
        </a>
    </x-order-form>
</x-layouts.app>
