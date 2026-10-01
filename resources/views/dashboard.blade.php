<x-layouts.app
    :title="'Dashboard — '.config('app.name')"
    :breadcrumbs="[
        ['label' => 'Dashboard'],
    ]"
>
    <h1 class="text-2xl font-semibold tracking-tight">Dashboard</h1>
    <p class="mt-2 text-[#706f6c] dark:text-[#A1A09A]">
        Welcome back, {{ $user->name }}. Use the sidebar to manage Orders and Items.
    </p>

    <div class="mt-8 flex gap-4">
        <a
            href="{{ route('orders.index') }}"
            class="rounded-md border border-[#e3e3e0] px-4 py-3 text-sm font-medium transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
        >
            Go to Orders
        </a>
        <a
            href="{{ route('items.index') }}"
            class="rounded-md border border-[#e3e3e0] px-4 py-3 text-sm font-medium transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
        >
            Go to Items
        </a>
    </div>
</x-layouts.app>
