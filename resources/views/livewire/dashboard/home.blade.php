<div>
    <div class="space-y-6">
        <!-- Welcome Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('dashboard.welcome_back', ['name' => auth()->user()->name]) }}
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">
                {{ __('dashboard.dashboard_subtitle') }}
            </p>
        </div>

        <!-- Trial/Subscription Status Banner -->
        @if ($trialStatus['is_trial'])
            <div class="bg-blue-50 dark:bg-blue-950/50 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-blue-800 dark:text-blue-200">
                            {{ __('dashboard.free_trial_active') }}
                        </p>
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            {{ __('dashboard.days_remaining', ['days' => (int) $trialStatus['days_remaining']]) }}
                            @if ($trialStatus['days_remaining'] <= 2)
                                <a href="{{ route('dashboard.billing') }}"
                                    class="underline font-semibold text-orange-600 dark:text-orange-400">
                                    {{ __('dashboard.subscribe_now_avoid') }}
                                </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @elseif(
            $trialStatus['expired'] &&
                !$activeSubscription &&
                auth()->user()->role != 'ADMIN' &&
                auth()->user()->role != 'SUPER_ADMIN')
            <div class="bg-red-50 dark:bg-red-950/50 rounded-xl p-4 border border-red-200 dark:border-red-800">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-red-800 dark:text-red-200">
                            {{ __('dashboard.trial_expired') }}
                        </p>
                        <p class="text-sm text-red-700 dark:text-red-300">
                            {{ __('dashboard.trial_expired_message') }}
                            <a href="{{ route('dashboard.billing') }}"
                                class="underline font-semibold">{{ __('dashboard.subscribe_now') }}</a>
                            {{ __('dashboard.to_continue_using') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- QR Codes Count -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                        </svg>

                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.total_qr_codes') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $qrCodesCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Subscription Status -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4">
                    <div
                        class="flex-shrink-0 p-3 {{ $activeSubscription ? 'bg-green-100 dark:bg-green-900/30' : 'bg-gray-100 dark:bg-gray-700' }} rounded-lg">
                        <svg class="h-6 w-6 {{ $activeSubscription ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.subscription') }}</p>
                        <p
                            class="text-lg font-bold {{ $activeSubscription ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ $activeSubscription ? $activeSubscription->plan->name : __('dashboard.no_active_plan') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.quick_action') }}</p>
                        <a href="{{ route('dashboard.qrcodes.create') }}"
                            class="text-lg font-bold text-purple-600 dark:text-purple-400 hover:underline">
                            {{ __('dashboard.create_new_qr') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent QR Codes -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('dashboard.recent_qr_codes') }}
                </h2>
                <a href="{{ route('dashboard.qrcodes') }}"
                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    {{ __('dashboard.view_all') }} →
                </a>
            </div>

            @if (count($recentQrCodes) > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($recentQrCodes as $qrCode)
                        <div
                            class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ ucfirst($qrCode->type) }} -
                                        {{ $qrCode->content?->name ?? ($qrCode->pdf?->name ?? 'QR Code') }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('dashboard.created') }} {{ $qrCode->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('dashboard.qrcodes.view', $qrCode) }}"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('dashboard.view') }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __('dashboard.no_qr_codes_yet') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('dashboard.get_started_by_creating') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard.qrcodes.create') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ __('dashboard.create_qr_code') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
