<div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('auth.login_title') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('auth.login_subtitle') }}
            </p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('auth.email') }}
                </label>
                <input wire:model="email" type="email" id="email" name="email" required autofocus
                    autocomplete="email" placeholder="{{ __('auth.email_placeholder') }}">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('auth.password') }}
                    </label>
                    {{-- <a href="#" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400">
                        {{ __('auth.forgot_password') }}
                    </a> --}}
                </div>
                <input wire:model="password" type="password" id="password" name="password" required
                    autocomplete="current-password" placeholder="{{ __('auth.password_placeholder') }}">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input wire:model="remember" type="checkbox" id="remember" name="remember"
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                <label for="remember" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('auth.remember_me') }}
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove>
                    {{ __('auth.login_button') }}
                </span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ __('auth.logging_in') }}
                </span>
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('auth.no_account') }}
                <a href="{{ route('register') }}"
                    class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400" wire:navigate>
                    {{ __('auth.register_link') }}
                </a>
            </p>
        </div>
    </div>
</div>
