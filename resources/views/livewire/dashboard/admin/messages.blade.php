<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.contact_messages') }}</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    {{ __('dashboard.view_messages') }}
                    @if ($unreadCount > 0)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                            {{ __('dashboard.unread_count', ['count' => $unreadCount]) }}
                        </span>
                    @endif
                </p>
            </div>
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

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <!-- Search -->
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
                            placeholder="{{ __('dashboard.search_messages') }}">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-48">
                    <label for="statusFilter" class="sr-only">{{ __('dashboard.status') }}</label>
                    <select wire:model.live="statusFilter" id="statusFilter"
                        class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">{{ __('dashboard.all_messages') }}</option>
                        <option value="unread">{{ __('dashboard.unread') }}</option>
                        <option value="read">{{ __('dashboard.read') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Messages Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start">
                                <button wire:click="sortBy('name')"
                                    class="group inline-flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:text-gray-700 dark:hover:text-gray-300">
                                    {{ __('dashboard.name') }}
                                    @if ($sortField === 'name')
                                        <svg class="ms-1 h-4 w-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <button wire:click="sortBy('email')"
                                    class="group inline-flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:text-gray-700 dark:hover:text-gray-300">
                                    {{ __('dashboard.email') }}
                                    @if ($sortField === 'email')
                                        <svg class="ms-1 h-4 w-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.subject') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <button wire:click="sortBy('created_at')"
                                    class="group inline-flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:text-gray-700 dark:hover:text-gray-300">
                                    {{ __('dashboard.received') }}
                                    @if ($sortField === 'created_at')
                                        <svg class="ms-1 h-4 w-4 {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($messages as $message)
                            <tr
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ !$message->is_read ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if (!$message->is_read)
                                            <span class="h-2 w-2 rounded-full bg-blue-600 me-2"></span>
                                        @endif
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-white {{ !$message->is_read ? 'font-semibold' : '' }}">
                                            {{ $message->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $message->email }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    <span class="truncate block max-w-xs">{{ $message->subject }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $message->is_read ? 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' }}">
                                        {{ $message->is_read ? __('dashboard.read') : __('dashboard.unread') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $message->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="viewMessage({{ $message->id }})"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="{{ __('dashboard.view') }}">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button wire:click="toggleRead({{ $message->id }})"
                                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                                            title="{{ $message->is_read ? __('dashboard.mark_unread') : __('dashboard.mark_read') }}">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                @if ($message->is_read)
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                                @endif
                                            </svg>
                                        </button>
                                        <button wire:click="deleteMessage({{ $message->id }})"
                                            wire:confirm="{{ __('dashboard.confirm_delete_message') }}"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            title="{{ __('dashboard.delete') }}">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">
                                            {{ __('dashboard.no_messages') }}
                                        </p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">
                                            {{ __('dashboard.try_adjusting_search') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($messages->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- View Message Modal -->
    @if ($showViewModal && $viewingMessage)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                    wire:click="closeViewModal"></div>

                <div
                    class="relative inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-start align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                            {{ __('dashboard.message_details') }}
                        </h3>
                        <button wire:click="closeViewModal"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.from') }}</label>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $viewingMessage->name }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.email') }}</label>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    <a href="mailto:{{ $viewingMessage->email }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $viewingMessage->email }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.subject') }}</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $viewingMessage->subject }}</p>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.message') }}</label>
                            <div
                                class="mt-1 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-white whitespace-pre-wrap">
                                {{ $viewingMessage->message }}
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('dashboard.received') }}:
                                {{ $viewingMessage->created_at->format('M d, Y H:i') }}
                            </p>
                            <a href="mailto:{{ $viewingMessage->email }}?subject=Re: {{ $viewingMessage->subject }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                <svg class="h-4 w-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ __('dashboard.reply') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
