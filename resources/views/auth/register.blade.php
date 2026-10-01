<x-layouts.guest :title="'Register — '.config('app.name')">
    <div class="mb-6">
        <h1 class="text-xl font-semibold tracking-tight">Create an account</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Fill in your details to get started.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
        @csrf

        <div class="flex flex-col gap-1.5">
            <label for="name" class="text-sm font-medium">Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
            >
            @error('name')
                <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="email" class="text-sm font-medium">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                autocomplete="new-password"
                class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
            >
            @error('password')
                <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="password_confirmation" class="text-sm font-medium">Confirm password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
            >
        </div>

        <button
            type="submit"
            class="mt-2 rounded-md bg-[#1b1b18] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
        >
            Register
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-[#1b1b18] underline underline-offset-4 dark:text-[#EDEDEC]">
            Log in
        </a>
    </p>
</x-layouts.guest>
