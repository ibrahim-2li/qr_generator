@php
    use Filament\Support\Icons\Heroicon;
    use Filament\Support\Enums\IconSize;
@endphp
<x-filament::page>
    <div class="space-y-6">
        @if (!$showPaymentForm)
            {{-- Plans Selection --}}
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-950 dark:text-white">
                    Simple, Transparent Pricing
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Choose the plan that's right for you and start creating professional QR codes today
                </p>
            </div>

            {{-- Trial Status Banner --}}
            @if ($this->trialStatus['is_trial'])
                <x-filament::section class="bg-blue-50 dark:bg-blue-950/50">
                    <div class="flex items-center gap-3">
                        <x-filament::icon :icon="Heroicon::OutlinedClock" class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                        <div>
                            <p class="font-medium text-blue-800 dark:text-blue-200">
                                ✅ Free Trial Active
                            </p>
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                You have <strong>{{ (int) $this->trialStatus['days_remaining'] }} days</strong>
                                remaining in your free trial.
                                @if ($this->trialStatus['days_remaining'] <= 2)
                                    <span class="text-orange-600 dark:text-orange-400 font-semibold">
                                        Subscribe now to avoid service interruption!
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </x-filament::section>
            @elseif($this->trialStatus['expired'] && !$this->currentSubscription)
                <x-filament::section class="bg-red-50 dark:bg-red-950/50">
                    <div class="flex items-center gap-3">
                        <x-filament::icon :icon="Heroicon::OutlinedExclamationTriangle" class="h-5 w-5 text-red-600 dark:text-red-400" />
                        <div>
                            <p class="font-medium text-red-800 dark:text-red-200">
                                Trial Expired
                            </p>
                            <p class="text-sm text-red-700 dark:text-red-300">
                                Your free trial has expired. Subscribe now to continue using QR codes.
                            </p>
                        </div>
                    </div>
                </x-filament::section>
            @endif

            @if ($this->currentSubscription)
                <x-filament::section class="bg-green-50 dark:bg-green-950/50">
                    <div class="flex items-center gap-3">
                        <x-filament::icon :icon="Heroicon::OutlinedCheckCircle" class="h-5 w-5 text-green-600 dark:text-green-400" />
                        <div>
                            <p class="font-medium text-green-800 dark:text-green-200">
                                ✅ Current Active Subscription
                            </p>
                            <p class="text-sm text-green-700 dark:text-green-300">
                                You are currently subscribed to
                                <strong>{{ $this->currentSubscription->plan->name }}</strong>
                                @if ($this->currentSubscription->ends_at)
                                    (expires {{ $this->currentSubscription->ends_at->format('M d, Y') }})
                                @endif
                            </p>
                        </div>
                    </div>
                </x-filament::section>
            @endif

            {{-- Plans Grid --}}
            <div
                style="display: grid; grid-template-columns: repeat({{ count($this->plans) }}, minmax(0, 1fr)); gap: 1.5rem; margin-top: 2rem;">
                @foreach ($this->plans as $index => $plan)
                    <x-filament::section :aside="false"
                        class="{{ $this->isCurrentPlan($plan->id) ? 'ring-2 ring-green-500' : ($index === 0 ? 'ring-2 ring-primary-500' : '') }}">
                        {{-- Badge --}}
                        @if ($index === 0 && !$this->isCurrentPlan($plan->id))
                            <x-slot name="heading">
                                <div class="flex items-center justify-between">
                                    <span>{{ $plan->name }}</span>
                                    <x-filament::badge color="primary">
                                        Most Popular
                                    </x-filament::badge>
                                </div>
                            </x-slot>
                        @elseif ($this->isCurrentPlan($plan->id))
                            <x-slot name="heading">
                                <div class="flex items-center justify-between">
                                    <span>{{ $plan->name }}</span>
                                    <x-filament::badge color="success">
                                        Current Plan
                                    </x-filament::badge>
                                </div>
                            </x-slot>
                        @else
                            <x-slot name="heading">
                                {{ $plan->name }}
                            </x-slot>
                        @endif

                        <x-slot name="description">
                            {{ $plan->description }}
                        </x-slot>

                        <div class="space-y-4">
                            {{-- Price --}}
                            <div class="text-center py-4">
                                <span class="text-4xl font-bold text-gray-950 dark:text-white">
                                    {{ number_format($plan->price / 100, 2) }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-400 ml-1">SAR</span>
                                <span class="text-gray-500 text-sm">/ {{ $plan->interval }}</span>
                            </div>

                            {{-- Features --}}
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <x-filament::icon :icon="Heroicon::OutlinedCheck" class="h-4 w-4 text-green-500" />
                                    Unlimited QR Codes
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <x-filament::icon :icon="Heroicon::OutlinedCheck" class="h-4 w-4 text-green-500" />
                                    Advanced Analytics
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <x-filament::icon :icon="Heroicon::OutlinedCheck" class="h-4 w-4 text-green-500" />
                                    Custom Branding
                                </li>
                                <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <x-filament::icon :icon="Heroicon::OutlinedCheck" class="h-4 w-4 text-green-500" />
                                    Priority Support
                                </li>
                            </ul>

                            {{-- Button --}}
                            @if ($this->isCurrentPlan($plan->id))
                                <x-filament::button color="gray" disabled class="w-full" :icon="Heroicon::OutlinedCheck">
                                    Active Plan
                                </x-filament::button>
                            @else
                                <x-filament::button wire:click="selectPlan({{ $plan->id }})" :color="$index === 0 ? 'primary' : 'gray'"
                                    class="w-full" :icon="Heroicon::OutlinedCreditCard">
                                    Choose Plan
                                </x-filament::button>
                            @endif
                        </div>
                    </x-filament::section>
                @endforeach
            </div>
        @else
            {{-- Payment Form --}}
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <x-filament::button wire:click="backToPlans" color="gray" :icon="Heroicon::OutlinedArrowLeft">
                        Back to Plans
                    </x-filament::button>
                    <h2 class="text-xl font-bold text-gray-950 dark:text-white">
                        Complete Your Payment
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    {{-- Plan Summary --}}
                    <x-filament::section>
                        <x-slot name="heading">
                            🔒 Order Summary
                        </x-slot>

                        <div class="space-y-3">
                            <div
                                class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">Plan</span>
                                <span
                                    class="font-medium text-gray-950 dark:text-white">{{ $selectedPlan->name }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">Billing Cycle</span>
                                <span
                                    class="font-medium text-gray-950 dark:text-white capitalize">{{ $selectedPlan->interval }}ly</span>
                            </div>
                            <div
                                class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">Price</span>
                                <span class="font-medium text-gray-950 dark:text-white">
                                    {{ number_format($selectedPlan->price / 100, 2) }} SAR
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 text-lg font-bold">
                                <span class="text-gray-950 dark:text-white">Total</span>
                                <span class="text-primary-600">
                                    {{ number_format($selectedPlan->price / 100, 2) }} SAR
                                </span>
                            </div>
                        </div>
                    </x-filament::section>

                    {{-- Payment Button --}}
                    <x-filament::section>
                        <x-slot name="heading">
                            ✅ Secure Payment
                        </x-slot>

                        <div class="space-y-4">
                            <div class="text-center">
                                <div
                                    class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                    <x-filament::icon :icon="Heroicon::OutlinedShieldCheck"
                                        class="h-6 w-6 text-green-600 dark:text-green-400" />
                                </div>
                                <p class="font-medium text-gray-950 dark:text-white">Secure Payment Gateway</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    You will be redirected to Moyasar's secure payment form.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center gap-2 rounded-lg bg-blue-50 p-2 dark:bg-blue-900/20">
                                    <x-filament::icon :icon="Heroicon::OutlinedLockClosed"
                                        class="h-4 w-4 text-blue-600 dark:text-blue-400" />
                                    <span class="text-sm text-blue-700 dark:text-blue-300">SSL Encrypted</span>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-blue-50 p-2 dark:bg-blue-900/20">
                                    <x-filament::icon :icon="Heroicon::OutlinedShieldCheck"
                                        class="h-4 w-4 text-blue-600 dark:text-blue-400" />
                                    <span class="text-sm text-blue-700 dark:text-blue-300">PCI DSS Compliant</span>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-blue-50 p-2 dark:bg-blue-900/20">
                                    <x-filament::icon :icon="Heroicon::OutlinedKey"
                                        class="h-4 w-4 text-blue-600 dark:text-blue-400" />
                                    <span class="text-sm text-blue-700 dark:text-blue-300">No card data stored</span>
                                </div>
                            </div>

                            @error('payment')
                                <div class="rounded-lg bg-red-50 p-3 dark:bg-red-900/20">
                                    <p class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
                                </div>
                            @enderror

                            <x-filament::button wire:click="processPayment" color="primary" class="w-full"
                                :icon="Heroicon::OutlinedCreditCard" wire:loading.attr="disabled">
                                <span wire:loading.remove>Pay {{ number_format($selectedPlan->price / 100, 2) }}
                                    SAR</span>
                                <span wire:loading>Processing...</span>
                            </x-filament::button>
                        </div>
                    </x-filament::section>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('payment-error', ({
                message
            }) => {
                alert('❌ ' + message);
            });
        });
    </script>
</x-filament::page>
