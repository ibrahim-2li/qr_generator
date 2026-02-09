<div>
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.my_profile') }}</h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">
                {{ __('dashboard.manage_profile') }}
            </p>
        </div>

        <!-- Profile Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ __('dashboard.profile_information') }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                {{ __('dashboard.update_profile_info') }}
            </p>

            @if (session()->has('profile_success'))
                <div
                    class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('profile_success') }}
                </div>
            @endif

            <form wire:submit="updateProfile" class="space-y-4">
                <!-- Avatar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('dashboard.profile_photo') }}
                    </label>
                    <div class="flex items-center gap-4">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover">
                        @elseif($existing_avatar)
                            <img src="{{ $existing_avatar }}" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div
                                class="w-20 h-20 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ strtoupper(substr($name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <input type="file" wire:model="avatar" accept="image/*" id="avatar" class="hidden">
                            <label for="avatar"
                                class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('dashboard.change_photo') }}
                            </label>
                            @error('avatar')
                                <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('dashboard.name') }}
                    </label>
                    <input type="text" wire:model="name"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('dashboard.email') }}
                    </label>
                    <input type="email" wire:model="email" dir="ltr"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors inline-flex items-center">
                        <svg wire:loading wire:target="updateProfile"
                            class="animate-spin -ml-1 mr-2 rtl:mr-0 rtl:ml-2 h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('dashboard.save') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ __('dashboard.update_password') }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                {{ __('dashboard.password_security') }}
            </p>

            @if (session()->has('password_success'))
                <div
                    class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('password_success') }}
                </div>
            @endif

            <form wire:submit="updatePassword" class="space-y-4">
                <!-- Current Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('dashboard.current_password') }}
                    </label>
                    <input type="password" wire:model="current_password"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('current_password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('dashboard.new_password') }}
                    </label>
                    <input type="password" wire:model="password"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('dashboard.confirm_password') }}
                    </label>
                    <input type="password" wire:model="password_confirmation"
                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors inline-flex items-center">
                        <svg wire:loading wire:target="updatePassword"
                            class="animate-spin -ml-1 mr-2 rtl:mr-0 rtl:ml-2 h-4 w-4 text-white" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ __('dashboard.update_password') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ __('dashboard.account_information') }}
            </h3>

            <dl class="space-y-4">
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('dashboard.account_role') }}
                    </dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ Auth::user()->role === 'super_admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                            {{ Auth::user()->role === 'admin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                            {{ Auth::user()->role === 'user' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                            {{ __('dashboard.role_' . (Auth::user()->role ?? 'user')) }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">{{ __('dashboard.member_since') }}</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ Auth::user()->created_at->format('F j, Y') }}</dd>
                </div>
                @if (Auth::user()->subscription)
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">{{ __('dashboard.subscription') }}</dt>
                        <dd class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ Auth::user()->subscription->plan?->name ?? __('dashboard.unknown') }}
                            <span
                                class="inline-flex items-center ml-2 rtl:mr-2 rtl:ml-0 px-2 py-0.5 rounded-full text-xs font-medium
                                {{ Auth::user()->subscription->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                {{ ucfirst(Auth::user()->subscription->status) }}
                            </span>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</div>
