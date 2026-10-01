<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard — {{ config('app.name', 'Laravel') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] antialiased dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        <header class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6">
                <span class="text-lg font-semibold tracking-tight">{{ config('app.name', 'Laravel') }}</span>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $user->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-md border border-[#e3e3e0] px-3 py-1.5 text-sm transition hover:border-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#EDEDEC]"
                        >
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6">
            <h1 class="text-2xl font-semibold tracking-tight">Dashboard</h1>
            <p class="mt-2 text-[#706f6c] dark:text-[#A1A09A]">
                You're logged in as {{ $user->email }}.
            </p>
        </main>
    </body>
</html>
