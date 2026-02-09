<div>
    <div class="space-y-6">
        @if ($subscription)
            <!-- Has Active Subscription -->

            <!-- Subscription Header / Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ __('dashboard.subscription_details') }}</h1>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.monthly_billing') }} •
                            @if ($subscription->auto_renew)
                                <span
                                    class="text-green-600 dark:text-green-400">{{ __('dashboard.will_auto_renew') }}</span>
                            @else
                                <span
                                    class="text-yellow-600 dark:text-yellow-400">{{ __('dashboard.manual_renewal_required') }}</span>
                            @endif
                        </p>
                    </div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $subscription->status === 'active'
                            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                            : ($subscription->status === 'canceled'
                                ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                                : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400') }}">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('dashboard.billing') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('dashboard.renew_subscription') }}
                    </a>
                    <a href="{{ route('dashboard.billing') }}"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        {{ __('dashboard.change_plan') }}
                    </a>
                </div>
            </div>

            <!-- Plan Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Plan -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('dashboard.plan_information') }}</h2>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.plan') }}</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $subscription->plan?->name ?? __('dashboard.unknown') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.price') }}</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                ${{ number_format($subscription->plan?->price ?? 0, 2) }} /
                                {{ strtolower($subscription->plan?->interval ?? 'month') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.billing_cycle') }}</span>
                            <span class="font-medium text-gray-900 dark:text-white capitalize">
                                {{ $subscription->plan?->interval ?? __('dashboard.monthly') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.next_billing') }}</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $subscription->ends_at?->format('M d, Y') ?? __('dashboard.not_set') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Days Remaining -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('dashboard.days_remaining_label') }}</h2>

                    <div class="flex items-center justify-center h-32">
                        @php
                            $daysRemaining = $subscription->ends_at
                                ? max(0, now()->diffInDays($subscription->ends_at, false))
                                : 0;
                        @endphp
                        <div class="text-center">
                            <span class="text-5xl font-bold text-blue-600 dark:text-blue-400">
                                {{ floor($daysRemaining) }}
                            </span>
                            <p class="text-gray-500 dark:text-gray-400 mt-2">{{ __('dashboard.days') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('dashboard.payment_history') }}</h2>
                </div>

                @if ($this->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('dashboard.date') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('dashboard.amount') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('dashboard.status') }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('dashboard.payment_id') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($this->payments as $payment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $payment->created_at->format('M d, Y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            ${{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $payment->status === 'completed' || $payment->status === 'paid' || $payment->status === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                                {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                                {{ $payment->status === 'failed' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <code
                                                class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs">{{ \Str::limit($payment->payment_id, 20) }}</code>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400">{{ __('dashboard.no_payment_history') }}</p>
                    </div>
                @endif
            </div>
        @else
            <!-- No Active Subscription -->

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center">
                <div
                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                    <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('dashboard.no_active_subscription') }}</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    {{ __('dashboard.no_subscription_message') }}
                </p>

                <a href="{{ route('dashboard.billing') }}"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-base font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    {{ __('dashboard.choose_plan') }}
                </a>
            </div>
        @endif
    </div>
</div>
