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
                        @php
                            $qrName =
                                $qrCode->content?->name ??
                                ($qrCode->pdf?->name ?? ($qrCode->url?->name ?? __('dashboard.unnamed')));
                            $qrStatus = $this->getQrCodeStatus($qrCode);
                            $shortUrl = config('app.url') . '/q/' . $qrCode->slug;
                        @endphp
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 px-4 py-4 sm:px-6 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center gap-4 sm:gap-6">
                                <!-- QR Code Thumbnail -->
                                <div class="shrink-0 hidden sm:block">
                                    @php
                                        $qrImage = $this->generateQrCodeImage($qrCode);
                                    @endphp
                                    @if ($qrImage)
                                        <img src="{{ $qrImage }}" alt="QR Code"
                                            class="w-16 h-16 rounded-lg border border-gray-100 dark:border-gray-600">
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Info Section -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $qrName }}
                                        </h3>
                                        <a href="{{ route('dashboard.qrcodes.edit', $qrCode->slug) }}"
                                            class="text-gray-400 hover:text-blue-500 transition-colors shrink-0"
                                            title="{{ __('dashboard.edit') }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 truncate"
                                            dir="ltr">{{ parse_url($shortUrl, PHP_URL_HOST) . '/' . $qrCode->slug }}</span>
                                        @if ($qrCode->slug)
                                            <button onclick="navigator.clipboard.writeText('{{ $shortUrl }}')"
                                                class="text-gray-400 hover:text-blue-500 transition-colors shrink-0"
                                                title="{{ __('dashboard.copy_url') }}">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('dashboard.type') }}
                                            <span
                                                class="font-medium text-gray-700 dark:text-gray-300
                                         {{ $qrCode->type === 'vcard' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg px-2 py-1' : '' }}
                                        {{ $qrCode->type === 'resume' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-lg px-2 py-1' : '' }}
                                        {{ $qrCode->type === 'pdf' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 rounded-lg px-2 py-1' : '' }}
                                        {{ $qrCode->type === 'url' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400 rounded-lg px-2 py-1' : '' }}
                                    
                                        ">{{ ucfirst($qrCode->type) }}</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Scans Count -->
                                <div class="hidden md:flex flex-col items-center px-4 sm:px-6 shrink-0">
                                    <span
                                        class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($qrCode->scan_count ?? 0) }}</span>
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-400">{{ __('dashboard.scans') }}</span>
                                </div>

                                <!-- Dates -->
                                <div class="hidden lg:block shrink-0 text-xs text-gray-500 dark:text-gray-400">
                                    <div>{{ __('dashboard.created_at') }}: {{ $qrCode->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="mt-0.5">{{ __('dashboard.last_updated') }}:
                                        {{ $qrCode->updated_at->format('M d, Y') }}</div>
                                </div>

                                <!-- Status Badge -->
                                <div class="hidden sm:flex shrink-0 px-4">
                                    @if ($qrStatus === 'active')
                                        <span
                                            class="inline-flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-400">
                                            <svg class="w-2 h-2 fill-current" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="4" />
                                            </svg>
                                            {{ __('dashboard.active') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-sm font-medium text-red-500 dark:text-red-400">
                                            <svg class="w-2 h-2 fill-current" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="4" />
                                            </svg>
                                            {{ __('dashboard.inactive') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <!-- Share / Copy Link -->
                                    <button
                                        onclick="navigator.clipboard.writeText('{{ url('/q/' . $qrCode->slug) }}')"
                                        class="p-2 text-gray-400 hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                        title="{{ __('dashboard.copy_url') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                    </button>

                                    <!-- Download -->
                                    <a href="{{ route('dashboard.qrcodes.view', $qrCode->slug) }}"
                                        class="p-2 text-gray-400 hover:text-green-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                        title="{{ __('dashboard.download_qr_code') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>

                                    <!-- More Actions Dropdown -->
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" @click.away="open = false"
                                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                            title="{{ __('dashboard.actions') }}">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="2" />
                                                <circle cx="12" cy="12" r="2" />
                                                <circle cx="12" cy="19" r="2" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute end-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                                            style="display: none;">
                                            <a href="{{ route('dashboard.qrcodes.view', $qrCode->slug) }}"
                                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ __('dashboard.view') }}
                                            </a>
                                            <a href="{{ route('dashboard.qrcodes.edit', $qrCode->slug) }}"
                                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                {{ __('dashboard.edit') }}
                                            </a>
                                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                            <button wire:click="deleteQrCode({{ $qrCode->id }})"
                                                wire:confirm="{{ __('dashboard.confirm_delete_qr') }}"
                                                class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                {{ __('dashboard.delete') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile-only info row -->
                            <div class="flex items-center justify-between mt-3 sm:hidden">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($qrCode->scan_count ?? 0) }}
                                        <span
                                            class="text-xs font-normal text-gray-500 dark:text-gray-400">{{ __('dashboard.scans') }}</span>
                                    </span>
                                </div>
                                @if ($qrStatus === 'active')
                                    <span
                                        class="inline-flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
                                        <svg class="w-1.5 h-1.5 fill-current" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="4" />
                                        </svg>
                                        {{ __('dashboard.active') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 text-xs font-medium text-red-500 dark:text-red-400">
                                        <svg class="w-1.5 h-1.5 fill-current" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="4" />
                                        </svg>
                                        {{ __('dashboard.inactive') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{-- <div
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
                        </div> --}}
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
