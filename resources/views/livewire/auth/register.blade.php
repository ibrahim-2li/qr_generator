<div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
        <div class="text-center mb-4">
            {{-- <h5 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('auth.register_title') }}
            </h5> --}}
            {{-- <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('auth.register_subtitle') }}
            </p> --}}

            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('auth.register_title') }}
            </p>
        </div>

        <form wire:submit="register" class="space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('auth.name') }}
                </label>
                <input wire:model="name" type="text" id="name" name="name" required autofocus
                    autocomplete="name" placeholder="{{ __('auth.name_placeholder') }}">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('auth.email') }}
                </label>
                <input wire:model="email" type="email" id="email" name="email" required autocomplete="email"
                    placeholder="{{ __('auth.email_placeholder') }}">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('auth.password') }}
                </label>
                <input wire:model="password" type="password" id="password" name="password" required
                    autocomplete="new-password" placeholder="{{ __('auth.password_placeholder') }}">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('auth.confirm_password') }}
                </label>
                <input wire:model="password_confirmation" type="password" id="password_confirmation"
                    name="password_confirmation" required autocomplete="new-password"
                    placeholder="{{ __('auth.confirm_password_placeholder') }}">
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Trial Info -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        {{ __('auth.trial_info') }}
                    </p>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove>
                    {{ __('auth.register_button') }}
                </span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ __('auth.registering') }}
                </span>
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('auth.have_account') }}
                <a href="{{ route('login') }}"
                    class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400" wire:navigate>
                    {{ __('auth.login_link') }}
                </a>
            </p>
        </div>
    </div>
</div>
