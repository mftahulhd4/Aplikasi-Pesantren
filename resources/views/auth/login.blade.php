<x-guest-layout>
    
    <div class="text-center mb-8">
        <img src="{{ asset('logo-pondok.png') }}" alt="Logo Pesantren Nurul Amin" class="w-28 mx-auto mb-4 drop-shadow-lg transition-transform hover:scale-105 duration-300">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight drop-shadow-sm">Pesantren Nurul Amin</h2>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            {{-- Fitur Tampilkan Sandi Dipertahankan --}}
            <x-text-input id="password" class="block mt-1 w-full"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="show_password" class="inline-flex items-center cursor-pointer">
                <input id="show_password" type="checkbox" x-model="showPassword" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800 cursor-pointer" name="show_password_toggle">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 font-medium">{{ __('Tampilkan sandi') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200 dark:border-gray-700/50">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 
                hover:text-gray-900 dark:hover:text-gray-100 rounded-md 
                focus:outline-none focus:ring-2 focus:ring-offset-2 
                focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors" 
                href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3 px-6 shadow-md">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>