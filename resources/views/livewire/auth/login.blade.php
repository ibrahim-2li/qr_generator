<div>
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-950">
                {{ __('auth.login_title') }}
            </h1>
            <p class="mt-2 text-slate-600">
                {{ __('auth.login_subtitle') }}
            </p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                    {{ __('auth.email') }}
                </label>
                <input wire:model="email" type="email" id="email" name="email" required autofocus
                    autocomplete="email" placeholder="{{ __('auth.email_placeholder') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-semibold text-slate-700">
                        {{ __('auth.password') }}
                    </label>
                </div>
                <input wire:model="password" type="password" id="password" name="password" required
                    autocomplete="current-password" placeholder="{{ __('auth.password_placeholder') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input wire:model="remember" type="checkbox" id="remember" name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <label for="remember" class="ms-2 text-sm text-slate-600">
                    {{ __('auth.remember_me') }}
                </label>
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 text-sm font-extrabold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
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

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-600">
                {{ __('auth.no_account') }}
                <a href="{{ route('register') }}"
                    class="font-bold text-blue-700 hover:text-blue-800" wire:navigate>
                    {{ __('auth.register_link') }}
                </a>
            </p>
        </div>
    </div>
</div>
