<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.manage_partners') }}</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    {{ __('dashboard.view_manage_partners') }}
                </p>
            </div>
            <button wire:click="openCreateModal"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="h-5 w-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('dashboard.add_partner') }}
            </button>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-green-500 dark:text-green-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Search -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex-1">
                <label for="search" class="sr-only">{{ __('dashboard.search') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" id="search"
                        class="block w-full ps-10 pe-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        placeholder="{{ __('dashboard.search') }}...">
                </div>
            </div>
        </div>

        <!-- Partners Grid -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            @if ($partners->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($partners as $partner)
                        <div
                            class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                            <div class="aspect-video bg-white dark:bg-gray-800 rounded-lg overflow-hidden mb-4">
                                @if ($partner->image)
                                    <img src="{{ Storage::url($partner->image) }}" alt="{{ $partner->name }}"
                                        class="w-full h-full object-contain p-2">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white truncate">{{ $partner->name }}</h3>
                            <a href="{{ $partner->url }}" target="_blank"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline truncate block mt-1">
                                {{ __('dashboard.visit_website') }}
                            </a>
                            <div class="flex items-center gap-2 mt-4">
                                <button wire:click="openEditModal({{ $partner->id }})"
                                    class="flex-1 inline-flex items-center justify-center px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                                    <svg class="h-4 w-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('dashboard.edit') }}
                                </button>
                                <button wire:click="deletePartner({{ $partner->id }})"
                                    wire:confirm="{{ __('dashboard.confirm_delete_partner') }}"
                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($partners->hasPages())
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        {{ $partners->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <p class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('dashboard.no_partners') }}
                    </p>
                    <p class="mt-1 text-gray-500 dark:text-gray-400">{{ __('dashboard.get_started_partner') }}</p>
                    <button wire:click="openCreateModal"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="h-5 w-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('dashboard.add_partner') }}
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                    wire:click="closeModal"></div>

                <div
                    class="relative inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-start align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                        {{ $editingId ? __('dashboard.edit_partner') : __('dashboard.add_partner') }}
                    </h3>

                    <form wire:submit="save" class="mt-4 space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.name') }}</label>
                            <input type="text" wire:model="name" id="name"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="{{ __('dashboard.partner_name') }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- URL -->
                        <div>
                            <label for="url"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.url') }}</label>
                            <input type="url" wire:model="url" id="url"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="https://example.com">
                            @error('url')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label for="image"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.partner_logo') }}</label>
                            @if ($existingImage && !$image)
                                <div class="mt-2 mb-2">
                                    <img src="{{ Storage::url($existingImage) }}" alt="Current logo"
                                        class="h-20 w-auto object-contain bg-gray-100 dark:bg-gray-700 rounded-lg p-2">
                                </div>
                            @endif
                            @if ($image)
                                <div class="mt-2 mb-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                        class="h-20 w-auto object-contain bg-gray-100 dark:bg-gray-700 rounded-lg p-2">
                                </div>
                            @endif
                            <input type="file" wire:model="image" id="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                {{ __('dashboard.cancel') }}
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                {{ $editingId ? __('dashboard.update') : __('dashboard.create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
