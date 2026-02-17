<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.qr_codes') }}</h1>
                @if (Auth::user()->trial_ends_at && Auth::user()->trial_ends_at > now())
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">
                        {{ __('dashboard.free_trial_active') }}
                    </span>
                @endif
            </div>

            @if (Auth::user()->canCreateQrCodes())
                <a href="{{ route('dashboard.qrcodes.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
                    </svg>
                    {{ __('dashboard.create_qr_code') }}
                </a>
            @else
                <a href="{{ route('dashboard.billing') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-sm font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    {{ __('dashboard.subscribe_to_create') }}
                </a>
            @endif
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Filters Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
            <!-- Search -->
            <div class="relative w-full sm:w-56">
                <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" id="search"
                    class="block w-full ps-9 pe-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    placeholder="{{ __('dashboard.search_by_name_or_url') }}">
            </div>

            <!-- Status Filter -->
            <div class="w-full sm:w-auto">
                <select wire:model.live="statusFilter" id="statusFilter"
                    class="block w-full py-2 px-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">{{ __('dashboard.qr_code_status') }}</option>
                    <option value="active">{{ __('dashboard.active') }}</option>
                    <option value="inactive">{{ __('dashboard.inactive') }}</option>
                </select>
            </div>

            <!-- Type Filter -->
            <div class="w-full sm:w-auto">
                <select wire:model.live="typeFilter" id="typeFilter"
                    class="block w-full py-2 px-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">{{ __('dashboard.qr_code_type') }}</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div class="w-full sm:w-auto">
                <select wire:model.live="sortField" id="sortBy"
                    class="block w-full py-2 px-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="created_at">{{ __('dashboard.sort_by') }}</option>
                    <option value="created_at">{{ __('dashboard.created_at') }}</option>
                    <option value="scan_count">{{ __('dashboard.scans') }}</option>
                    <option value="type">{{ __('dashboard.type') }}</option>
                </select>
            </div>
        </div>

        <!-- QR Codes List -->
        <div class="space-y-3">
            @forelse($qrCodes as $qrCode)
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
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('dashboard.scans') }}</span>
                        </div>

                        <!-- Dates -->
                        <div class="hidden lg:block shrink-0 text-xs text-gray-500 dark:text-gray-400">
                            <div>{{ __('dashboard.created_at') }}: {{ $qrCode->created_at->format('M d, Y') }}</div>
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
                            <button onclick="navigator.clipboard.writeText('{{ url('/q/' . $qrCode->slug) }}')"
                                class="p-2 text-gray-400 hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                title="{{ __('dashboard.copy_url') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </button>

                            <!-- Download -->
                            <a href="{{ route('dashboard.qrcodes.view', $qrCode->slug) }}"
                                class="p-2 text-gray-400 hover:text-green-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                title="{{ __('dashboard.download_qr_code') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ __('dashboard.view') }}
                                    </a>
                                    <a href="{{ route('dashboard.qrcodes.edit', $qrCode->slug) }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12">
                    <div class="flex flex-col items-center">
                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">
                            {{ __('dashboard.no_qr_codes') }}</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">
                            @if ($search || $typeFilter || $statusFilter)
                                {{ __('dashboard.try_adjusting_search') }}
                            @else
                                {{ __('dashboard.get_started_qr') }}
                            @endif
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($qrCodes->hasPages())
            <div class="mt-4">
                {{ $qrCodes->links() }}
            </div>
        @endif
    </div>
</div>
