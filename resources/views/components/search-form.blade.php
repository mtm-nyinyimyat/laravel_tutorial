@props([
    'action',
    'placeholder' => 'Search...',
])

<form method="GET" action="{{ $action }}" class="flex flex-wrap items-center gap-2" {{ $attributes }}>
    <div class="relative min-w-0 flex-1 sm:max-w-sm">
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-[#706f6c] dark:text-[#A1A09A]">
            <x-icons.search />
        </span>
        <input
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="{{ $placeholder }}"
            class="w-full rounded-md border border-[#e3e3e0] bg-white py-2 pr-3 pl-9 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
        >
    </div>
    <button
        type="submit"
        class="inline-flex items-center gap-1.5 rounded-md border border-[#e3e3e0] px-3 py-2 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
    >
        Search
    </button>
    @if (request()->filled('search'))
        <a
            href="{{ $action }}"
            class="inline-flex items-center rounded-md border border-[#e3e3e0] px-3 py-2 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
        >
            Clear
        </a>
    @endif
</form>
