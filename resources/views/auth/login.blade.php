<x-layouts.guest :title="'Log in — '.config('app.name')">
    <div class="mb-6">
        <h1 class="text-xl font-semibold tracking-tight">Log in</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Welcome back. Enter your credentials to continue.
        </p>
    </div>

    @session('status')
        <div class="mb-4 rounded-md bg-green-50 px-3 py-2 text-sm text-green-700 dark:bg-green-950 dark:text-green-300">
            {{ $value }}
        </div>
    @endsession

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        <div class="flex flex-col gap-1.5">
            <label for="email" class="text-sm font-medium">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
            >
            @error('email')
                <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="password" class="text-sm font-medium">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
            >
            @error('password')
                <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
            @enderror
        </div>

        <label for="remember" class="flex items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <input
                id="remember"
                type="checkbox"
                name="remember"
                class="rounded border-[#e3e3e0] dark:border-[#3E3E3A]"
            >
            Remember me
        </label>

        <button
            type="submit"
            class="mt-2 rounded-md bg-[#1b1b18] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
        >
            Log in
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-medium text-[#1b1b18] underline underline-offset-4 dark:text-[#EDEDEC]">
            Register
        </a>
    </p>
</x-layouts.guest>
