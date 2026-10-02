@props(['title' => null, 'breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="icon" href="/favicon.png" type="image/png" sizes="32x32">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] antialiased dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        <div class="flex min-h-screen">
            <aside class="flex w-56 shrink-0 flex-col border-r border-[#e3e3e0] bg-white dark:border-[#3E3E3A] dark:bg-[#161615]">
                <div class="border-b border-[#e3e3e0] px-5 py-4 dark:border-[#3E3E3A]">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-tight">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <nav class="flex flex-1 flex-col gap-1 p-3">
                    <a
                        href="{{ route('orders.index') }}"
                        @class([
                            'inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition',
                            'bg-[#1b1b18] text-white dark:bg-[#EDEDEC] dark:text-[#1C1C1A]' => request()->routeIs('orders.*'),
                            'text-[#706f6c] hover:bg-[#f5f5f0] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:bg-[#1D1D1B] dark:hover:text-[#EDEDEC]' => ! request()->routeIs('orders.*'),
                        ])
                    >
                        <x-icons.orders />
                        Orders
                    </a>
                    <a
                        href="{{ route('items.index') }}"
                        @class([
                            'inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition',
                            'bg-[#1b1b18] text-white dark:bg-[#EDEDEC] dark:text-[#1C1C1A]' => request()->routeIs('items.*'),
                            'text-[#706f6c] hover:bg-[#f5f5f0] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:bg-[#1D1D1B] dark:hover:text-[#EDEDEC]' => ! request()->routeIs('items.*'),
                        ])
                    >
                        <x-icons.items />
                        Items
                    </a>
                </nav>

                <div class="border-t border-[#e3e3e0] p-4 dark:border-[#3E3E3A]">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-1.5 rounded-md border border-[#e3e3e0] px-3 py-1.5 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
                        >
                            <x-icons.logout />
                            Log out
                        </button>
                    </form>
                </div>
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                <header class="flex h-[57px] items-center justify-end border-b border-[#e3e3e0] bg-white px-6 dark:border-[#3E3E3A] dark:bg-[#161615]">
                    <details class="relative">
                        <summary class="flex cursor-pointer list-none items-center gap-1.5 text-sm text-[#706f6c] transition hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC] [&::-webkit-details-marker]:hidden">
                            <span class="max-w-48 truncate">{{ auth()->user()->name }}</span>
                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </summary>
                        <div class="absolute right-0 z-10 mt-2 w-40 rounded-md border border-[#e3e3e0] bg-white py-1 shadow-sm dark:border-[#3E3E3A] dark:bg-[#161615]">
                            <a
                                href="{{ route('profile.edit') }}"
                                class="block px-3 py-2 text-sm transition hover:bg-[#f5f5f0] dark:hover:bg-[#1D1D1B]"
                            >
                                Profile
                            </a>
                        </div>
                    </details>
                </header>

                <main class="flex-1 overflow-auto">
                    <div class="mx-auto max-w-5xl px-6 py-8">
                        <x-breadcrumbs :items="$breadcrumbs" />

                        @session('status')
                            <div
                                data-toast
                                class="mb-4 rounded-md bg-green-50 px-3 py-2 text-sm text-green-700 transition-opacity duration-300 dark:bg-green-950 dark:text-green-300"
                            >
                                {{ $value }}
                            </div>
                        @endsession

                        @session('error')
                            <div
                                data-toast
                                class="mb-4 rounded-md bg-red-50 px-3 py-2 text-sm text-[#f53003] transition-opacity duration-300 dark:bg-red-950 dark:text-[#FF4433]"
                            >
                                {{ $value }}
                            </div>
                        @endsession

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <dialog
            id="confirm-delete-dialog"
            class="fixed inset-0 m-auto w-[calc(100%-2rem)] max-w-md rounded-lg border border-[#e3e3e0] bg-white p-0 text-[#1b1b18] shadow-lg backdrop:bg-black/40 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
        >
            <form method="dialog" class="flex flex-col gap-4 p-6">
                <div>
                    <h2 class="text-lg font-semibold tracking-tight">Confirm delete</h2>
                    <p id="confirm-delete-message" class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Are you sure you want to delete this?
                    </p>
                </div>
                <div class="flex items-center justify-end gap-3">
                    <button
                        type="submit"
                        value="cancel"
                        class="rounded-md border border-[#e3e3e0] px-4 py-2 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        value="confirm"
                        class="rounded-md bg-[#f53003] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#d42a03] dark:bg-[#FF4433] dark:hover:bg-[#ff5c4d]"
                    >
                        Delete
                    </button>
                </div>
            </form>
        </dialog>
    </body>
</html>
