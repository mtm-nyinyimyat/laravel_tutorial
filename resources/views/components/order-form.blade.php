@props([
    'action',
    'method' => 'POST',
    'order' => null,
    'items',
    'submit' => 'Save',
])

@php
    $defaultSelected = $order
        ? $order->orderItems->mapWithKeys(
            fn ($orderItem) => [$orderItem->item_id => ['item_id' => $orderItem->item_id, 'quantity' => $orderItem->quantity]]
        )->all()
        : [];

    $selectedByItemId = collect(old('items', $defaultSelected))
        ->filter(fn ($row) => filled($row['item_id'] ?? null))
        ->keyBy('item_id');
@endphp

<form method="POST" action="{{ $action }}" class="flex max-w-2xl flex-col gap-4">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="flex flex-col gap-1.5">
        <label for="status" class="text-sm font-medium">Status</label>
        <select
            id="status"
            name="status"
            class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
        >
            @foreach (['pending', 'processing', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $order?->status ?? 'pending') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col gap-2">
        <p class="text-sm font-medium">Items</p>
        @error('items')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror

        @forelse ($items as $index => $item)
            @php
                $selected = $selectedByItemId->get($item->id);
                $isSelected = $selected !== null;
                $quantity = $isSelected ? (int) ($selected['quantity'] ?? 1) : 0;
            @endphp
            <div class="flex items-center gap-3 rounded-md border border-[#e3e3e0] px-3 py-2 dark:border-[#3E3E3A]">
                <input
                    type="checkbox"
                    name="items[{{ $index }}][item_id]"
                    value="{{ $item->id }}"
                    id="item-{{ $item->id }}"
                    @checked($isSelected)
                    class="rounded border-[#e3e3e0] dark:border-[#3E3E3A]"
                    onchange="const qty = this.closest('div').querySelector('input[type=number]'); qty.disabled = !this.checked; qty.value = this.checked ? Math.max(1, Number(qty.value) || 1) : 0;"
                >
                <label for="item-{{ $item->id }}" class="flex-1 text-sm">
                    {{ $item->name }}
                    <span class="text-[#706f6c] dark:text-[#A1A09A]">(${{ number_format($item->price, 2) }})</span>
                </label>
                <input
                    type="number"
                    name="items[{{ $index }}][quantity]"
                    min="0"
                    value="{{ $isSelected ? max(1, $quantity) : 0 }}"
                    @disabled(! $isSelected)
                    class="w-20 rounded-md border border-[#e3e3e0] bg-white px-2 py-1 text-sm outline-none focus:border-[#1b1b18] disabled:opacity-50 dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                >
            </div>
        @empty
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                No items available.
                <a href="{{ route('items.create') }}" class="underline underline-offset-4">Create an item</a>
                first.
            </p>
        @endforelse

        @error('items.*.item_id')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
        @error('items.*.quantity')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button
            type="submit"
            class="rounded-md bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black disabled:opacity-50 dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
            @disabled($items->isEmpty())
        >
            {{ $submit }}
        </button>
        {{ $slot }}
    </div>
</form>
