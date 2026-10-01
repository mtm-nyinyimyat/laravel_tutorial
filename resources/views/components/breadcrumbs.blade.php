@props([
    'items' => [],
])

@if (count($items) > 0)
    <nav {{ $attributes->merge(['class' => 'mb-4', 'aria-label' => 'Breadcrumb']) }}>
        <ol class="flex flex-wrap items-center gap-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            @foreach ($items as $index => $item)
                @php
                    $label = $item['label'] ?? '';
                    $url = $item['url'] ?? null;
                    $isLast = $index === array_key_last($items);
                @endphp

                @if ($index > 0)
                    <li aria-hidden="true" class="select-none">/</li>
                @endif

                <li @class(['font-medium text-[#1b1b18] dark:text-[#EDEDEC]' => $isLast])>
                    @if ($url && ! $isLast)
                        <a href="{{ $url }}" class="transition hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                            {{ $label }}
                        </a>
                    @else
                        <span @if ($isLast) aria-current="page" @endif>{{ $label }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
