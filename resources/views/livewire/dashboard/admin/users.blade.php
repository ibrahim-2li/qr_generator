<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.manage_users') }}</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    {{ __('dashboard.view_manage_users') }}
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
                            placeholder="{{ __('dashboard.search_name_email') }}">
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="w-full sm:w-48">
                    <label for="roleFilter" class="sr-only">{{ __('dashboard.role') }}</label>
                    <select wire:model.live="roleFilter" id="roleFilter"
                        class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">{{ __('dashboard.all_roles') }}</option>
                        <option value="USER">{{ __('dashboard.role_user') }}</option>
                        <option value="ADMIN">{{ __('dashboard.role_admin') }}</option>
                        <option value="SUPER_ADMIN">{{ __('dashboard.role_super_admin') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Users Table -->
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
                                {{ __('dashboard.role') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.qr_codes') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.subscriptions') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <button wire:click="sortBy('created_at')"
                                    class="group inline-flex items-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:text-gray-700 dark:hover:text-gray-300">
                                    {{ __('dashboard.joined') }}
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
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if ($user->getAvatarUrl())
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                <span class="text-blue-600 dark:text-blue-400 font-medium text-sm">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->role === 'SUPER_ADMIN' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                                        {{ $user->role === 'ADMIN' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                        {{ $user->role === 'USER' ? 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300' : '' }}">
                                        {{ $user->role === 'SUPER_ADMIN' ? __('dashboard.role_super_admin') : '' }}
                                        {{ $user->role === 'ADMIN' ? __('dashboard.role_admin') : '' }}
                                        {{ $user->role === 'USER' ? __('dashboard.role_user') : '' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format($user->qr_codes_count) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format($user->subscriptions_count) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->hasActiveSubscription())
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            {{ __('dashboard.subscribed') }}
                                        </span>
                                    @elseif($user->isOnTrial())
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            {{ __('dashboard.trial') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300">
                                            {{ __('dashboard.inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="viewUser({{ $user->id }})"
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
                                        <button wire:click="openEditModal({{ $user->id }})"
                                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                                            title="{{ __('dashboard.edit') }}">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        @if (Auth::id() !== $user->id)
                                            <button wire:click="deleteUser({{ $user->id }})"
                                                wire:confirm="{{ __('dashboard.confirm_delete_user') }}"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                title="{{ __('dashboard.delete') }}">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">
                                            {{ __('dashboard.no_users') }}
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
            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- View User Modal -->
    @if ($showViewModal && $viewingUser)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                    wire:click="closeViewModal"></div>

                <div
                    class="relative inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-start align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                            {{ __('dashboard.user_details') }}
                        </h3>
                        <button wire:click="closeViewModal"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <!-- User Avatar and Name -->
                        <div class="flex items-center gap-4">
                            @if ($viewingUser->getAvatarUrl())
                                <img class="h-16 w-16 rounded-full object-cover"
                                    src="{{ $viewingUser->getAvatarUrl() }}" alt="{{ $viewingUser->name }}">
                            @else
                                <div
                                    class="h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <span class="text-blue-600 dark:text-blue-400 font-medium text-xl">
                                        {{ strtoupper(substr($viewingUser->name, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $viewingUser->name }}</h4>
                                <p class="text-gray-500 dark:text-gray-400">{{ $viewingUser->email }}</p>
                            </div>
                        </div>

                        <!-- User Info Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.role') }}</label>
                                <p class="mt-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $viewingUser->role === 'SUPER_ADMIN' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                                        {{ $viewingUser->role === 'ADMIN' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                        {{ $viewingUser->role === 'USER' ? 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300' : '' }}">
                                        {{ $viewingUser->role === 'SUPER_ADMIN' ? __('dashboard.role_super_admin') : '' }}
                                        {{ $viewingUser->role === 'ADMIN' ? __('dashboard.role_admin') : '' }}
                                        {{ $viewingUser->role === 'USER' ? __('dashboard.role_user') : '' }}
                                    </span>
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.status') }}</label>
                                <p class="mt-1">
                                    @if ($viewingUser->hasActiveSubscription())
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            {{ __('dashboard.subscribed') }}
                                        </span>
                                    @elseif($viewingUser->isOnTrial())
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            {{ __('dashboard.trial') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300">
                                            {{ __('dashboard.inactive') }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.qr_codes') }}</label>
                                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($viewingUser->qr_codes_count) }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('dashboard.subscriptions') }}</label>
                                <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($viewingUser->subscriptions_count) }}</p>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <label class="text-gray-500 dark:text-gray-400">{{ __('dashboard.joined') }}</label>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $viewingUser->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            @if ($viewingUser->trial_ends_at)
                                <div>
                                    <label
                                        class="text-gray-500 dark:text-gray-400">{{ __('dashboard.trial_ends') }}</label>
                                    <p class="text-gray-900 dark:text-white">
                                        {{ $viewingUser->trial_ends_at->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button wire:click="closeViewModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                {{ __('dashboard.close') }}
                            </button>
                            <button wire:click="closeViewModal"
                                wire:click.stop="openEditModal({{ $viewingUser->id }})"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                {{ __('dashboard.edit_user') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit User Modal -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                    wire:click="closeEditModal"></div>

                <div
                    class="relative inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-start align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                        {{ __('dashboard.edit_user') }}
                    </h3>

                    <form wire:submit="save" class="mt-4 space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.name') }}</label>
                            <input type="text" wire:model="name" id="name"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.email') }}</label>
                            <input type="email" wire:model="email" id="email"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.role') }}</label>
                            <select wire:model="role" id="role"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="USER">{{ __('dashboard.role_user') }}</option>
                                <option value="ADMIN">{{ __('dashboard.role_admin') }}</option>
                                <option value="SUPER_ADMIN">{{ __('dashboard.role_super_admin') }}</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.new_password') }}
                                <span
                                    class="text-gray-400">({{ __('dashboard.leave_blank_password') }})</span></label>
                            <input type="password" wire:model="password" id="password"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('dashboard.confirm_new_password') }}</label>
                            <input type="password" wire:model="password_confirmation" id="password_confirmation"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" wire:click="closeEditModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                {{ __('dashboard.cancel') }}
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                {{ __('dashboard.update_user') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
