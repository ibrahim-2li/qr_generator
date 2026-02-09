<div>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <a href="{{ route('dashboard.qrcodes.view', $qrCode->id) }}" wire:navigate
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-2">
                <svg class="w-4 h-4 mr-1 rtl:ml-1 rtl:mr-0 rtl:rotate-180" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                {{ __('dashboard.back_to_qr_code') }}
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.edit_qr_code') }}</h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">
                {{ __('dashboard.information') }}
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <!-- Type Display (Read-only) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.qr_code_type') }}
                </h3>

                <div class="flex items-center gap-4">
                    <div
                        class="flex-shrink-0 p-3 {{ $type === 'vcard' ? 'bg-blue-100 dark:bg-blue-900/50' : 'bg-purple-100 dark:bg-purple-900/50' }} rounded-lg">
                        @if ($type === 'vcard')
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($type) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('dashboard.type_cannot_change') }}
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" wire:model="is_dynamic"
                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                        <div>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ __('dashboard.dynamic_qr_code') }}
                            </span>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.dynamic_qr_description') }}
                            </p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- vCard Fields -->
            @if ($type === 'vcard')
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('dashboard.vcard_information') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Profile Photo -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.profile_photo') }}
                            </label>
                            @if ($existing_profile_photo && !$content_profile_photo)
                                <div class="mb-2">
                                    <img src="{{ $existing_profile_photo }}"
                                        class="w-24 h-24 rounded-full object-cover">
                                    <p class="text-sm text-gray-500 mt-1">{{ __('dashboard.current_photo') }}</p>
                                </div>
                            @endif
                            <input type="file" wire:model="content_profile_photo" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/50 dark:file:text-blue-400 rtl:file:ml-4 rtl:file:mr-0">
                            @error('content_profile_photo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            @if ($content_profile_photo)
                                <img src="{{ $content_profile_photo->temporaryUrl() }}"
                                    class="mt-2 w-24 h-24 rounded-full object-cover">
                                <p class="text-sm text-green-600 mt-1">{{ __('dashboard.new_photo') }}</p>
                            @endif
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.name') }} *
                            </label>
                            <input type="text" wire:model="content_name"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.title') }}
                            </label>
                            <input type="text" wire:model="content_title"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.phone') }} *
                            </label>
                            <input type="tel" wire:model="content_phone" dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.email') }} *
                            </label>
                            <input type="email" wire:model="content_email" dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Company -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.company') }}
                            </label>
                            <input type="text" wire:model="content_company"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_company')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h4 class="text-md font-medium text-gray-900 dark:text-white mt-6 mb-4">
                        {{ __('dashboard.social_links') }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                LinkedIn
                            </label>
                            <input type="url" wire:model="content_linkedin"
                                placeholder="https://linkedin.com/in/..." dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_linkedin')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                X (Twitter)
                            </label>
                            <input type="url" wire:model="content_x" placeholder="https://x.com/..."
                                dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_x')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Facebook
                            </label>
                            <input type="url" wire:model="content_facebook"
                                placeholder="https://facebook.com/..." dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_facebook')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Instagram
                            </label>
                            <input type="url" wire:model="content_instagram"
                                placeholder="https://instagram.com/..." dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_instagram')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                YouTube
                            </label>
                            <input type="url" wire:model="content_youtube" placeholder="https://youtube.com/..."
                                dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_youtube')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Snapchat
                            </label>
                            <input type="text" wire:model="content_snap" placeholder="username" dir="ltr"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('content_snap')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h4 class="text-md font-medium text-gray-900 dark:text-white mt-6 mb-4">
                        {{ __('dashboard.light_color') }} / {{ __('dashboard.dark_color') }}
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.light_color') }}
                            </label>
                            <input type="color" wire:model="content_color_l"
                                class="block w-full h-10 rounded-lg border-gray-300 dark:border-gray-600 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.dark_color') }}
                            </label>
                            <input type="color" wire:model="content_color_d"
                                class="block w-full h-10 rounded-lg border-gray-300 dark:border-gray-600 cursor-pointer">
                        </div>
                    </div>
                </div>
            @endif

            <!-- PDF Fields -->
            @if ($type === 'pdf')
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('dashboard.pdf_information') }}
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.name') }} *
                            </label>
                            <input type="text" wire:model="pdf_name"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('pdf_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.description') }} *
                            </label>
                            <textarea wire:model="pdf_description" rows="3"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('pdf_description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('dashboard.pdf_file') }}
                            </label>
                            @if ($existing_pdf_file && !$pdf_file)
                                <p class="text-sm text-gray-500 mb-2">{{ __('dashboard.current_file') }}:
                                    {{ basename($existing_pdf_file) }}</p>
                            @endif
                            <input type="file" wire:model="pdf_file" accept="application/pdf"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900/50 dark:file:text-purple-400 rtl:file:ml-4 rtl:file:mr-0">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.leave_empty_keep_file') }}
                            </p>
                            @error('pdf_file')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('dashboard.light_color') }}
                                </label>
                                <input type="color" wire:model="pdf_color_l"
                                    class="block w-full h-10 rounded-lg border-gray-300 dark:border-gray-600 cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('dashboard.dark_color') }}
                                </label>
                                <input type="color" wire:model="pdf_color_d"
                                    class="block w-full h-10 rounded-lg border-gray-300 dark:border-gray-600 cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('dashboard.qrcodes.view', $qrCode->id) }}" wire:navigate
                    class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    {{ __('dashboard.cancel') }}
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors inline-flex items-center">
                    <svg wire:loading wire:target="save"
                        class="animate-spin -ml-1 mr-2 rtl:mr-0 rtl:ml-2 h-4 w-4 text-white" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ __('dashboard.save_changes') }}
                </button>
            </div>
        </form>
    </div>
</div>
