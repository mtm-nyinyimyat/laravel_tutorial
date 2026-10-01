<x-layouts.app
    :title="'Profile — '.config('app.name')"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Profile'],
    ]"
>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Profile</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Manage your account information and password.</p>
    </div>

    <div class="flex max-w-xl flex-col gap-8">
        <section class="rounded-lg border border-[#e3e3e0] p-6 dark:border-[#3E3E3A]">
            <h2 class="text-lg font-semibold tracking-tight">Profile information</h2>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Update your name and email address.</p>

            <form method="POST" action="{{ route('profile.update') }}" class="mt-5 flex flex-col gap-4">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-sm font-medium">Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
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
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="username"
                        class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
                    >
                    @error('email')
                        <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button
                        type="submit"
                        class="rounded-md bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
                    >
                        Update
                    </button>
                </div>
            </form>
        </section>

        <section class="rounded-lg border border-[#e3e3e0] p-6 dark:border-[#3E3E3A]">
            <h2 class="text-lg font-semibold tracking-tight">Update password</h2>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Ensure your account is using a strong password.</p>

            <form method="POST" action="{{ route('profile.password') }}" class="mt-5 flex flex-col gap-4">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-1.5">
                    <label for="current_password" class="text-sm font-medium">Current password</label>
                    <input
                        id="current_password"
                        type="password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
                    >
                    @error('current_password', 'updatePassword')
                        <p class="text-sm text-[#f53003] dark:text-[#FF4433]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-sm font-medium">New password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm outline-none focus:border-[#1b1b18] dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:focus:border-[#EDEDEC]"
                    >
                    @error('password', 'updatePassword')
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

                <div>
                    <button
                        type="submit"
                        class="rounded-md bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
                    >
                        Update password
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-layouts.app>
