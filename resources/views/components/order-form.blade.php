@props([
    'action',
    'method' => 'POST',
    'order' => null,
    'items',
    'submit' => 'Save',
])

@php
    $existingRows = collect(old('items', $order
        ? $order->orderItems->map(fn ($orderItem) => [
            'item_id' => $orderItem->item_id,
            'quantity' => $orderItem->quantity,
        ])->values()->all()
        : []
    ))->values();

    $catalogItems = $items->map(fn ($item) => [
        'id' => (string) $item->id,
        'label' => $item->name.' ($'.number_format($item->price, 2).')',
    ])->values();
@endphp

<form method="POST" action="{{ $action }}" class="flex max-w-2xl flex-col gap-4" id="order-form">
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

    <div class="flex flex-col gap-3">
        <div class="flex items-center justify-between gap-3">
            <p class="text-sm font-medium">Items</p>
            @if ($items->isNotEmpty())
                <button
                    type="button"
                    id="add-order-item"
                    class="rounded-md border border-[#e3e3e0] px-3 py-1.5 text-sm transition hover:border-[#1b1b18] disabled:cursor-not-allowed disabled:opacity-50 dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
                >
                    Add Item
                </button>
            @endif
        </div>

        @error('items')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
        @error('items.*.item_id')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
        @error('items.*.quantity')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror

        @if ($items->isEmpty())
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                No items available.
                <a href="{{ route('items.create') }}" class="underline underline-offset-4">Create an item</a>
                first.
            </p>
        @else
            <div id="order-item-rows" class="flex flex-col gap-2">
                @foreach ($existingRows as $index => $row)
                    <div class="order-item-row flex items-center gap-3 rounded-md border border-[#e3e3e0] px-3 py-2 dark:border-[#3E3E3A]" data-index="{{ $index }}">
                        <select
                            name="items[{{ $index }}][item_id]"
                            required
                            class="order-item-select min-w-0 flex-1 rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
                        >
                            <option value="">Select item</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" @selected((string) ($row['item_id'] ?? '') === (string) $item->id)>
                                    {{ $item->name }} (${{ number_format($item->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <input
                            type="number"
                            name="items[{{ $index }}][quantity]"
                            min="1"
                            value="{{ max(1, (int) ($row['quantity'] ?? 1)) }}"
                            required
                            class="w-24 rounded-md border border-[#e3e3e0] bg-white px-2 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                            aria-label="Quantity"
                        >
                        <button
                            type="button"
                            class="remove-order-item rounded-md border border-[#e3e3e0] px-3 py-2 text-sm text-[#706f6c] transition hover:border-[#f53003] hover:text-[#f53003] dark:border-[#3E3E3A] dark:text-[#A1A09A] dark:hover:border-[#FF4433] dark:hover:text-[#FF4433]"
                        >
                            Remove
                        </button>
                    </div>
                @endforeach
            </div>

            <p id="order-items-empty" class="text-sm text-[#706f6c] dark:text-[#A1A09A] {{ $existingRows->isNotEmpty() ? 'hidden' : '' }}">
                Click Add Item to include products in this order.
            </p>
        @endif
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

@if ($items->isNotEmpty())
    <template id="order-item-row-template">
        <div class="order-item-row flex items-center gap-3 rounded-md border border-[#e3e3e0] px-3 py-2 dark:border-[#3E3E3A]">
            <select
                name="items[__INDEX__][item_id]"
                required
                class="order-item-select min-w-0 flex-1 rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
            >
                <option value="">Select item</option>
            </select>
            <input
                type="number"
                name="items[__INDEX__][quantity]"
                min="1"
                value="1"
                required
                class="w-24 rounded-md border border-[#e3e3e0] bg-white px-2 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]"
                aria-label="Quantity"
            >
            <button
                type="button"
                class="remove-order-item rounded-md border border-[#e3e3e0] px-3 py-2 text-sm text-[#706f6c] transition hover:border-[#f53003] hover:text-[#f53003] dark:border-[#3E3E3A] dark:text-[#A1A09A] dark:hover:border-[#FF4433] dark:hover:text-[#FF4433]"
            >
                Remove
            </button>
        </div>
    </template>

    <script>
        (() => {
            const catalog = @json($catalogItems);
            const rowsContainer = document.getElementById('order-item-rows');
            const emptyMessage = document.getElementById('order-items-empty');
            const addButton = document.getElementById('add-order-item');
            const template = document.getElementById('order-item-row-template');

            if (! rowsContainer || ! addButton || ! template) {
                return;
            }

            let nextIndex = {{ $existingRows->count() }};

            const syncEmptyState = () => {
                if (emptyMessage) {
                    emptyMessage.classList.toggle('hidden', rowsContainer.children.length > 0);
                }
            };

            const selectedItemIds = () => Array.from(rowsContainer.querySelectorAll('.order-item-select'))
                .map((select) => select.value)
                .filter((value) => value !== '');

            const refreshSelectOptions = () => {
                const selectedIds = selectedItemIds();

                rowsContainer.querySelectorAll('.order-item-select').forEach((select) => {
                    const currentValue = select.value;
                    const availableItems = catalog.filter((item) => {
                        return item.id === currentValue || ! selectedIds.includes(item.id);
                    });

                    select.innerHTML = '';

                    const placeholder = document.createElement('option');
                    placeholder.value = '';
                    placeholder.textContent = 'Select item';
                    select.appendChild(placeholder);

                    availableItems.forEach((item) => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.label;
                        option.selected = item.id === currentValue;
                        select.appendChild(option);
                    });
                });

                addButton.disabled = selectedIds.length >= catalog.length && rowsContainer.children.length >= catalog.length;
            };

            const addRow = () => {
                if (selectedItemIds().length >= catalog.length && rowsContainer.children.length >= catalog.length) {
                    return;
                }

                const html = template.innerHTML.replaceAll('__INDEX__', String(nextIndex));
                rowsContainer.insertAdjacentHTML('beforeend', html);
                nextIndex += 1;
                syncEmptyState();
                refreshSelectOptions();
            };

            addButton.addEventListener('click', addRow);

            rowsContainer.addEventListener('change', (event) => {
                if (event.target.classList.contains('order-item-select')) {
                    refreshSelectOptions();
                }
            });

            rowsContainer.addEventListener('click', (event) => {
                const removeButton = event.target.closest('.remove-order-item');

                if (! removeButton) {
                    return;
                }

                removeButton.closest('.order-item-row')?.remove();
                syncEmptyState();
                refreshSelectOptions();
            });

            syncEmptyState();
            refreshSelectOptions();
        })();
    </script>
@endif
