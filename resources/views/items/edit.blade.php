<x-layouts.app
    :title="'Edit item — '.config('app.name')"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Items', 'url' => route('items.index')],
        ['label' => $item->name, 'url' => route('items.show', $item)],
        ['label' => 'Edit'],
    ]"
>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Edit item</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Update {{ $item->name }}.</p>
    </div>

    <x-item-form :action="route('items.update', $item)" method="PUT" :item="$item" submit="Update item">
        <a href="{{ route('items.index') }}" class="text-sm text-[#706f6c] underline-offset-4 hover:underline dark:text-[#A1A09A]">
            Cancel
        </a>
    </x-item-form>
</x-layouts.app>
