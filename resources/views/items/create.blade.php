<x-layouts.app :title="'New item — '.config('app.name')">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">New item</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Add a product to the catalog.</p>
    </div>

    <x-item-form :action="route('items.store')" submit="Create item">
        <a href="{{ route('items.index') }}" class="text-sm text-[#706f6c] underline-offset-4 hover:underline dark:text-[#A1A09A]">
            Cancel
        </a>
    </x-item-form>
</x-layouts.app>
