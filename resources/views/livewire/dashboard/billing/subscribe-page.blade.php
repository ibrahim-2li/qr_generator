<div>
    <div class="space-y-6">
        @if (!$showPaymentForm)
            {{-- Plans Selection --}}
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('dashboard.simple_pricing') }}
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('dashboard.choose_plan_subtitle') }}
                </p>
            </div>

            {{-- Trial Status Banner --}}
            @if ($trialStatus['is_trial'])
                <div class="bg-blue-50 dark:bg-blue-950/50 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-medium text-blue-800 dark:text-blue-200">
                                ✅ {{ __('dashboard.free_trial_active') }}
                            </p>
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                {{ __('dashboard.days_remaining', ['days' => (int) $trialStatus['days_remaining']]) }}
                                @if ($trialStatus['days_remaining'] <= 2)
                                    <span class="text-orange-600 dark:text-orange-400 font-semibold">
                                        {{ __('dashboard.subscribe_now_avoid') }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($trialStatus['expired'] && !$currentSubscription)
                <div class="bg-red-50 dark:bg-red-950/50 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="font-medium text-red-800 dark:text-red-200">
                                {{ __('dashboard.trial_expired') }}
                            </p>
                            <p class="text-sm text-red-700 dark:text-red-300">
                                {{ __('dashboard.trial_expired_message') }} {{ __('dashboard.subscribe_now') }}
                                {{ __('dashboard.to_continue_using') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($currentSubscription)
                <div class="bg-green-50 dark:bg-green-950/50 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-medium text-green-800 dark:text-green-200">
                                ✅ {{ __('dashboard.current_subscription') }}
                            </p>
                            <p class="text-sm text-green-700 dark:text-green-300">
                                {{ __('dashboard.current_plan') }}:
                                <strong>{{ $currentSubscription->plan->name }}</strong>
                                @if ($currentSubscription->ends_at)
                                    ({{ __('dashboard.expires') }}
                                    {{ $currentSubscription->ends_at->format('M d, Y') }})
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Plans Grid --}}
            <div
                class="grid gap-6 mt-8 {{ count($plans) >= 3 ? 'grid-cols-1 md:grid-cols-3' : 'grid-cols-1 md:grid-cols-2' }}">
                @foreach ($plans as $index => $plan)
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-2 transition-all hover:shadow-lg 
                        {{ $this->isCurrentPlan($plan->id) ? 'border-green-500 ring-2 ring-green-500/20' : ($index === 0 ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-gray-200 dark:border-gray-700') }}">

                        {{-- Badge --}}
                        @if ($index === 0 && !$this->isCurrentPlan($plan->id))
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-600 px-4 py-1 text-xs font-semibold text-white shadow-sm">
                                    {{ __('dashboard.most_popular') }}
                                </span>
                            </div>
                        @elseif ($this->isCurrentPlan($plan->id))
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                <span
                                    class="inline-flex items-center rounded-full bg-green-600 px-4 py-1 text-xs font-semibold text-white shadow-sm">
                                    {{ __('dashboard.current_plan') }}
                                </span>
                            </div>
                        @endif

                        <div class="p-6 space-y-4">
                            {{-- Plan Name --}}
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $plan->name }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $plan->description }}</p>
                            </div>

                            {{-- Price --}}
                            <div class="text-center py-4">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($plan->price / 100, 2) }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-400 ms-1">{{ __('dashboard.SAR') }}</span>
                                <span class="text-gray-500 text-sm">/ {{ $plan->interval /30 }} {{ __('dashboard.months') }}</span>
                            </div>

                            {{-- Features --}}
                            <ul class="space-y-3 text-sm">
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.unlimited_qr_codes') }}
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.advanced_analytics') }}
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.custom_branding') }}
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('dashboard.priority_support') }}
                                </li>
                            </ul>

                            {{-- Button --}}
                            <div class="pt-4">
                                @if ($this->isCurrentPlan($plan->id))
                                    <button disabled
                                        class="w-full flex items-center justify-center gap-2 rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-400 dark:bg-gray-700 dark:text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ __('dashboard.active_plan') }}
                                    </button>
                                @else
                                    <button wire:click="selectPlan({{ $plan->id }})"
                                        class="w-full flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold transition-colors
                                            {{ $index === 0 ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600' }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        {{ __('dashboard.choose_plan') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Payment Form --}}
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <button wire:click="backToPlans"
                        class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('dashboard.back_to_plans') }}
                    </button>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ __('dashboard.complete_payment') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    {{-- Plan Summary --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            {{ __('dashboard.order_summary') }}
                        </h3>

                        <div class="space-y-3">
                            <div
                                class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.plan') }}</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $selectedPlan->name }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                <span
                                    class="text-gray-600 dark:text-gray-400">{{ __('dashboard.billing_cycle') }}</span>
                                <span
                                    class="font-medium text-gray-900 dark:text-white capitalize">{{ $selectedPlan->interval }}ly</span>
                            </div>
                            <div
                                class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('dashboard.price') }}</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ number_format($selectedPlan->price / 100, 2) }} SAR
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 text-lg font-bold">
                                <span class="text-gray-900 dark:text-white">{{ __('dashboard.total') }}</span>
                                <span class="text-blue-600">
                                    {{ number_format($selectedPlan->price / 100, 2) }} SAR
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Button --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <!-- <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">✅
                            {{ __('dashboard.secure_payment') }}</h3> -->

                        <div class="space-y-4">
                            <div class="text-center">
                                <div
                                    class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ __('dashboard.secure_payment_gateway') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('dashboard.redirect_to_moyasar') }}
                                </p>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center gap-2 rounded-lg bg-blue-50 p-2 dark:bg-blue-900/20">
                                    <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span
                                        class="text-sm text-blue-700 dark:text-blue-300">{{ __('dashboard.ssl_encrypted') }}</span>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-blue-50 p-2 dark:bg-blue-900/20">
                                    <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span
                                        class="text-sm text-blue-700 dark:text-blue-300">{{ __('dashboard.pci_compliant') }}</span>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-blue-50 p-2 dark:bg-blue-900/20">
                                    <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    <span
                                        class="text-sm text-blue-700 dark:text-blue-300">{{ __('dashboard.no_card_stored') }}</span>
                                </div>
                            </div>

                            @error('payment')
                                <div class="rounded-lg bg-red-50 p-3 dark:bg-red-900/20">
                                    <p class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                                </div>
                            @enderror

                            <button wire:click="processPayment" wire:loading.attr="disabled"
                                class="w-full flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove>
                                    <svg class="h-4 w-4 inline me-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    {{ __('dashboard.pay_amount', ['amount' => number_format($selectedPlan->price / 100, 2)]) }}
                                </span>
                                <span wire:loading>{{ __('dashboard.processing') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>
