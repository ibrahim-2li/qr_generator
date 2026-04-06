<div>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.manage_subscriptions') }}</h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">
                {{ __('dashboard.view_manage_subscriptions') }}
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 ps-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="block w-full ps-10 pe-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="{{ __('dashboard.search_subscriptions') }}">
                    </div>
                </div>

                <div class="w-full sm:w-48">
                    <select wire:model.live="statusFilter"
                        class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="">{{ __('dashboard.all_statuses') }}</option>
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}">{{ ucfirst($label) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Subscriptions Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.user') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.plan') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.status') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.period') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                <span class="text-blue-600 dark:text-blue-400 font-medium text-sm">
                                                    {{ strtoupper(substr($subscription->user?->name ?? 'U', 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ms-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $subscription->user?->name ?? __('dashboard.unknown') }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $subscription->user?->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $subscription->plan?->name ?? __('dashboard.unknown') }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        ${{ number_format($subscription->plan?->price/ 100, 2) }}/{{ strtolower($subscription->plan?->interval ?? 'month') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:change="updateStatus({{ $subscription->id }}, $event.target.value)"
                                        class="text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white
                                                {{ $subscription->status === 'active' ? 'text-green-600' : '' }}
                                                {{ $subscription->status === 'canceled' ? 'text-red-600' : '' }}
                                                {{ $subscription->status === 'pending' ? 'text-yellow-600' : '' }}">
                                        @foreach ($statuses as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $subscription->status === $value ? 'selected' : '' }}>
                                                {{ ucfirst($label) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if ($subscription->starts_at && $subscription->ends_at)
                                        <div>{{ $subscription->starts_at->format('M d, Y') }}</div>
                                        <div class="text-xs">{{ __('dashboard.to') }}
                                            {{ $subscription->ends_at->format('M d, Y') }}</div>
                                    @else
                                        <span class="text-gray-400">{{ __('dashboard.not_set') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <button wire:click="deleteSubscription({{ $subscription->id }})"
                                        wire:confirm="{{ __('dashboard.confirm_delete_subscription') }}"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        title="{{ __('dashboard.delete') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">
                                            {{ __('dashboard.no_subscriptions') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($subscriptions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
