<x-layouts.app
    :title="'Edit order #'.$order->id.' — '.config('app.name')"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Orders', 'url' => route('orders.index')],
        ['label' => 'Order #'.$order->id, 'url' => route('orders.show', $order)],
        ['label' => 'Edit'],
    ]"
>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Edit order #{{ $order->id }}</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Update status and line items.</p>
    </div>

    <x-order-form :action="route('orders.update', $order)" method="PUT" :order="$order" :items="$items" submit="Update order">
        <a href="{{ route('orders.index') }}" class="text-sm text-[#706f6c] underline-offset-4 hover:underline dark:text-[#A1A09A]">
            Cancel
        </a>
    </x-order-form>
</x-layouts.app>
