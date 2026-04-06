<div>
    <div
        class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
        <div class="text-center">
            <div
                class="mx-auto w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>

            @if ($plan)
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Complete Payment for {{ $plan->name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    You will be redirected to our secure payment provider to complete your purchase.
                </p>

                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-8">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($plan->price / 100, 2) }} {{ __('dashboard.SAR') }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        per {{ $plan->interval /30  }} {{ __('dashboard.months') }}
                    </div>
                </div>
            @else
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Payment Processing
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    Please wait while we process your payment...
                </p>
            @endif
        </div>
    </div>
</div>
