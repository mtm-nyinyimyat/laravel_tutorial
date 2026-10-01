@props([
    'action',
    'method' => 'POST',
    'item' => null,
    'submit' => 'Save',
])

<form method="POST" action="{{ $action }}" class="flex max-w-xl flex-col gap-4">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="flex flex-col gap-1.5">
        <label for="name" class="text-sm font-medium">Name</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name', $item?->name) }}"
            required
            class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
        >
        @error('name')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col gap-1.5">
        <label for="description" class="text-sm font-medium">Description</label>
        <textarea
            id="description"
            name="description"
            rows="3"
            class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
        >{{ old('description', $item?->description) }}</textarea>
        @error('description')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col gap-1.5">
        <label for="price" class="text-sm font-medium">Price</label>
        <input
            id="price"
            type="number"
            name="price"
            step="0.01"
            min="0"
            value="{{ old('price', $item?->price) }}"
            required
            class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
        >
        @error('price')
            <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button
            type="submit"
            class="rounded-md bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
        >
            {{ $submit }}
        </button>
        {{ $slot }}
    </div>
</form>
