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
        @elseif($trialStatus['expired'] && !$activeSubscription)
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
                        {{-- <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg> --}}
                        <svg viewBox="0 0 28 28" class="h-6 w-6" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <title>ic_fluent_qr_code_24_regular</title>
                                <desc>Created with Sketch.</desc>
                                <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <g id="ic_fluent_qr_code_24_regular" fill="#1a3be0" fill-rule="nonzero">
                                        <path
                                            d="M10.75,15 C11.9926407,15 13,16.0073593 13,17.25 L13,22.75 C13,23.9926407 11.9926407,25 10.75,25 L5.25,25 C4.00735931,25 3,23.9926407 3,22.75 L3,17.25 C3,16.0073593 4.00735931,15 5.25,15 L10.75,15 Z M18.3346843,15 L18.3346843,18.3333333 L21.6671089,18.3333333 L21.6671089,21.6666667 L18.3346843,21.6660851 L18.3346843,24.9994184 L15.0013509,24.9994184 L15.0013509,21.6660851 L18.3337756,21.6666667 L18.3337756,18.3333333 L15.0013509,18.3333333 L15.0013509,15 L18.3346843,15 Z M25.0004423,21.6660851 L25.0004423,24.9994184 L21.6671089,24.9994184 L21.6671089,21.6660851 L25.0004423,21.6660851 Z M10.75,16.5 L5.25,16.5 C4.83578644,16.5 4.5,16.8357864 4.5,17.25 L4.5,22.75 C4.5,23.1642136 4.83578644,23.5 5.25,23.5 L10.75,23.5 C11.1642136,23.5 11.5,23.1642136 11.5,22.75 L11.5,17.25 C11.5,16.8357864 11.1642136,16.5 10.75,16.5 Z M9.5,18.5 L9.5,21.5 L6.5,21.5 L6.5,18.5 L9.5,18.5 Z M25.0004423,15 L25.0004423,18.3333333 L21.6671089,18.3333333 L21.6671089,15 L25.0004423,15 Z M10.75,3 C11.9926407,3 13,4.00735931 13,5.25 L13,10.75 C13,11.9926407 11.9926407,13 10.75,13 L5.25,13 C4.00735931,13 3,11.9926407 3,10.75 L3,5.25 C3,4.00735931 4.00735931,3 5.25,3 L10.75,3 Z M22.75,3 C23.9926407,3 25,4.00735931 25,5.25 L25,10.75 C25,11.9926407 23.9926407,13 22.75,13 L17.25,13 C16.0073593,13 15,11.9926407 15,10.75 L15,5.25 C15,4.00735931 16.0073593,3 17.25,3 L22.75,3 Z M10.75,4.5 L5.25,4.5 C4.83578644,4.5 4.5,4.83578644 4.5,5.25 L4.5,10.75 C4.5,11.1642136 4.83578644,11.5 5.25,11.5 L10.75,11.5 C11.1642136,11.5 11.5,11.1642136 11.5,10.75 L11.5,5.25 C11.5,4.83578644 11.1642136,4.5 10.75,4.5 Z M22.75,4.5 L17.25,4.5 C16.8357864,4.5 16.5,4.83578644 16.5,5.25 L16.5,10.75 C16.5,11.1642136 16.8357864,11.5 17.25,11.5 L22.75,11.5 C23.1642136,11.5 23.5,11.1642136 23.5,10.75 L23.5,5.25 C23.5,4.83578644 23.1642136,4.5 22.75,4.5 Z M9.5,6.5 L9.5,9.5 L6.5,9.5 L6.5,6.5 L9.5,6.5 Z M21.5,6.5 L21.5,9.5 L18.5,9.5 L18.5,6.5 L21.5,6.5 Z"
                                            id="🎨-Color"> </path>
                                    </g>
                                </g>
                            </g>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01" />
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
