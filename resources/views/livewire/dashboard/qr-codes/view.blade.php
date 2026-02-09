<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('dashboard.qrcodes') }}" wire:navigate
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-2">
                    <svg class="w-4 h-4 mr-1 rtl:ml-1 rtl:mr-0 rtl:rotate-180" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('dashboard.back_to_qr_codes') }}
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $qrCode->content?->name ?? ($qrCode->pdf?->name ?? ($qrCode->url?->name ?? __('dashboard.qr_code_details'))) }}
                </h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $qrCode->type === 'vcard' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                        {{ $qrCode->type === 'resume' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                        {{ $qrCode->type === 'pdf' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                        {{ $qrCode->type === 'url' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                    ">
                        {{ ucfirst($qrCode->type) }}
                    </span>
                    <span class="ml-2 rtl:mr-2 rtl:ml-0">{{ __('dashboard.created') }}
                        {{ $qrCode->created_at->diffForHumans() }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.qrcodes.edit', $qrCode->slug) }}" wire:navigate
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('dashboard.edit') }}
                </a>
                <button wire:click="deleteQrCode" wire:confirm="{{ __('dashboard.confirm_delete_qr_forever') }}"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    {{ __('dashboard.delete') }}
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- QR Code Display -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('dashboard.qr_code') }}</h3>

                    @if ($qrCodeImage)
                        <div class="flex flex-col items-center">
                            <img src="{{ $qrCodeImage }}" alt="QR Code" class="w-48 h-48 mb-4">
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('dashboard.qr_code_url') }}
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text" readonly value="{{ url('/q/' . $qrCode->slug) }}"
                                        dir="ltr"
                                        class="flex-1 text-sm bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-white">
                                    <button onclick="navigator.clipboard.writeText('{{ url('/q/' . $qrCode->slug) }}')"
                                        class="px-3 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg transition-colors"
                                        title="{{ __('dashboard.copy_url') }}">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <a href="{{ $qrCodeImage }}" download="qr-code-{{ $qrCode->slug }}.png"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                {{ __('dashboard.download_qr_code') }}
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            {{ __('dashboard.qr_not_available') }}</p>
                    @endif
                </div>

                <!-- Stats Card -->
                <div
                    class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('dashboard.statistics') }}</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.total_scans') }}</span>
                            <span
                                class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($qrCode->scan_count ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.dynamic') }}</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $qrCode->is_dynamic ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ $qrCode->is_dynamic ? __('dashboard.yes') : __('dashboard.no') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.created_by') }}</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $qrCode->user?->name ?? __('dashboard.unknown') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Details -->
            <div class="lg:col-span-2">
                @if ($qrCode->type === 'vcard' && $qrCode->content)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                            {{ __('dashboard.vcard_information') }}</h3>

                        <div class="flex items-start gap-6 mb-6">
                            @if ($qrCode->content->profile_photo_url)
                                <img src="{{ $qrCode->content->profile_photo_url }}"
                                    alt="{{ $qrCode->content->name }}"
                                    class="w-24 h-24 rounded-full object-cover ring-4 ring-gray-100 dark:ring-gray-700">
                            @else
                                <div
                                    class="w-24 h-24 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center ring-4 ring-gray-100 dark:ring-gray-700">
                                    <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ strtoupper(substr($qrCode->content->name ?? 'U', 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $qrCode->content->name }}</h4>
                                @if ($qrCode->content->title)
                                    <p class="text-gray-600 dark:text-gray-400">{{ $qrCode->content->title }}</p>
                                @endif
                                @if ($qrCode->content->company)
                                    <p class="text-gray-500 dark:text-gray-500">{{ $qrCode->content->company }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($qrCode->content->email)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('dashboard.email') }}</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $qrCode->content->email }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($qrCode->content->phone)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('dashboard.phone') }}</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white" dir="ltr">
                                            {{ $qrCode->content->phone }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Social Links -->
                        @php
                            $socialLinks = collect([
                                'linkedin' => ['label' => 'LinkedIn', 'value' => $qrCode->content->linkedin],
                                'x' => ['label' => 'X (Twitter)', 'value' => $qrCode->content->x],
                                'facebook' => ['label' => 'Facebook', 'value' => $qrCode->content->facebook],
                                'instagram' => ['label' => 'Instagram', 'value' => $qrCode->content->instagram],
                                'youtube' => ['label' => 'YouTube', 'value' => $qrCode->content->youtube],
                                'snap' => ['label' => 'Snapchat', 'value' => $qrCode->content->snap],
                            ])->filter(fn($item) => !empty($item['value']));
                        @endphp

                        @if ($socialLinks->isNotEmpty())
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('dashboard.social_links') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($socialLinks as $key => $link)
                                        <a href="{{ $link['value'] }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 transition-colors">
                                            <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            {{ $link['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Colors -->
                        <div class="mt-6 flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('dashboard.light_color') }}:
                                </span>
                                <div class="w-6 h-6 rounded border border-gray-300 dark:border-gray-600"
                                    style="background-color: {{ $qrCode->content->color_l ?? '#ffffff' }}"></div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('dashboard.dark_color') }}:
                                </span>
                                <div class="w-6 h-6 rounded border border-gray-300 dark:border-gray-600"
                                    style="background-color: {{ $qrCode->content->color_d ?? '#000000' }}"></div>
                            </div>
                        </div>
                    </div>
                @elseif($qrCode->type === 'pdf' && $qrCode->pdf)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                            {{ __('dashboard.pdf_information') }}</h3>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.name') }}</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ $qrCode->pdf->name }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.description') }}</label>
                                <p class="text-gray-900 dark:text-white">{{ $qrCode->pdf->description }}</p>
                            </div>
                            @if ($qrCode->pdf->file)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                        {{ __('dashboard.pdf_file') }}
                                    </label>
                                    <a href="{{ Storage::url($qrCode->pdf->file) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __('dashboard.view_pdf') }}
                                    </a>
                                </div>
                            @endif

                            <!-- Colors -->
                            <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.light_color') }}:
                                    </span>
                                    <div class="w-6 h-6 rounded border border-gray-300 dark:border-gray-600"
                                        style="background-color: {{ $qrCode->pdf->color_l ?? '#ffffff' }}"></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.dark_color') }}:
                                    </span>
                                    <div class="w-6 h-6 rounded border border-gray-300 dark:border-gray-600"
                                        style="background-color: {{ $qrCode->pdf->color_d ?? '#000000' }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($qrCode->type === 'url' && $qrCode->url)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                            {{ __('dashboard.url_information') }}</h3>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.name') }}</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ $qrCode->url->name }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('dashboard.url') }}</label>
                                <div class="flex items-center gap-2">
                                    <a href="{{ $qrCode->url->url }}" target="_blank" rel="noopener noreferrer"
                                        class="text-blue-600 dark:text-blue-400 hover:underline break-all">
                                        {{ $qrCode->url->url }}
                                    </a>
                                    <button onclick="navigator.clipboard.writeText('{{ $qrCode->url->url }}')"
                                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                                        title="{{ __('dashboard.copy_url') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Colors -->
                            <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.light_color') }}:
                                    </span>
                                    <div class="w-6 h-6 rounded border border-gray-300 dark:border-gray-600"
                                        style="background-color: {{ $qrCode->url->color_l ?? '#ffffff' }}"></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('dashboard.dark_color') }}:
                                    </span>
                                    <div class="w-6 h-6 rounded border border-gray-300 dark:border-gray-600"
                                        style="background-color: {{ $qrCode->url->color_d ?? '#000000' }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            {{ __('dashboard.qr_code_details') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ __('dashboard.no_content_available') }}
                        </p>
                    </div>
                @endif

                <!-- Metadata -->
                <div
                    class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('dashboard.metadata') }}</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.slug') }}</dt>
                            <dd class="text-gray-900 dark:text-white font-mono">{{ $qrCode->slug }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.type') }}</dt>
                            <dd class="text-gray-900 dark:text-white">{{ ucfirst($qrCode->type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.created_at') }}</dt>
                            <dd class="text-gray-900 dark:text-white">
                                {{ $qrCode->created_at->format('F j, Y g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.last_updated') }}</dt>
                            <dd class="text-gray-900 dark:text-white">
                                {{ $qrCode->updated_at->format('F j, Y g:i A') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
