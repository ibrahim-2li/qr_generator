@php
    use Filament\Support\Icons\Heroicon;
@endphp
<x-filament::page>
    <div class="max-w-6xl mx-auto space-y-8">
        @if (!$showPaymentForm)
            {{-- Plans Selection --}}
            <div>
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white mb-6">
                    Choose a subscription plan 💳
                    <br />
                </h2>

                {{-- Trial Status Banner --}}
                @if ($this->trialStatus['is_trial'])
                    <div
                        class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="flex items-center gap-3">

                            <div>
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    ✅ Free Trial Active
                                </h3>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    You have <strong>{{ $this->trialStatus['days_remaining'] }} days</strong> remaining
                                    in your free trial.
                                    @if ($this->trialStatus['days_remaining'] <= 2)
                                        <span class="text-orange-600 dark:text-orange-400 font-semibold">Subscribe now
                                            to avoid service interruption!</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($this->trialStatus['expired'] && !$this->currentSubscription)
                    <div
                        class="fi-color fi-color-danger fi-bg-color-400 hover:fi-bg-color-300 dark:fi-bg-color-600 dark:hover:fi-bg-color-500 fi-text-color-950 hover:fi-text-color-900 dark:fi-text-color-950 dark:hover:fi-text-color-950 fi-btn fi-size-md mb-6">


                        <div class="flex items-center gap-3">
                            {{-- <svg width="30" height="30" viewBox="0 0 200 200" data-name="Layer 1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: #ffffff;
                                        }

                                        .cls-2 {
                                            fill: #ffc861;
                                        }

                                        .cls-3 {
                                            fill: #2f4360;
                                        }

                                        .cls-4 {
                                            fill: none;
                                            stroke: #2f4360;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-width: 6px;
                                        }
                                    </style>
                                </defs>
                                <title />
                                <path class="cls-1"
                                    d="M180.77,164a11.28,11.28,0,0,1-10.82,8H30a11.33,11.33,0,0,1-9.81-17l70-121.16a11.32,11.32,0,0,1,19.62,0l70,121.16A11.15,11.15,0,0,1,180.77,164Z" />
                                <path class="cls-2"
                                    d="M180.77,164H36.07c-8.72,0-5.17-9.44-.81-17l68.3-118.3a11.2,11.2,0,0,1,6.25,5.1l70,121.16A11.15,11.15,0,0,1,180.77,164Z" />
                                <path class="cls-3"
                                    d="M101.69,139.57q-2.92-.07-5.84,0A4.72,4.72,0,0,1,91,135.15l-3.7-58.79a4.74,4.74,0,0,1,4.55-5q6.9-.25,13.81,0a4.74,4.74,0,0,1,4.55,5l-3.7,58.79A4.72,4.72,0,0,1,101.69,139.57Z" />
                                <path class="cls-3"
                                    d="M105.62,149.69a6.88,6.88,0,0,1-13.69,0c-0.27-3.54,2.8-6.66,6.84-6.66S105.88,146.15,105.62,149.69Z" />
                                <path class="cls-4"
                                    d="M20.23,154.92l70-121.16a11.33,11.33,0,0,1,19.63,0l70,121.16a11.33,11.33,0,0,1-9.81,17H30A11.33,11.33,0,0,1,20.23,154.92Z" />
                            </svg> --}}
                            <div>
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">

                                    <x-filament::badge :icon="Heroicon::OutlinedXMark">
                                        Trial Expired
                                    </x-filament::badge>
                                </h3>
                                <p class="text-sm text-red-700 dark:text-red-300">
                                    Your free trial has expired. Subscribe now to continue using QR codes.
                                </p>
                            </div>
                        </div>
                    </div>

                @endif

                @if ($this->currentSubscription)
                    <div
                        class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <div class="flex items-center gap-3">

                            <div>
                                <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                                    ✅ Current Active Subscription
                                </h3>
                                <p class="text-sm text-green-700 dark:text-green-300">
                                    You are currently subscribed to
                                    <strong>{{ $this->currentSubscription->plan->name }}</strong>
                                    @if ($this->currentSubscription->ends_at)
                                        (expires {{ $this->currentSubscription->ends_at->format('M d, Y') }})
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->plans as $plan)
                    <x-filament::card
                        class="relative overflow-hidden hover:shadow-lg transition-shadow {{ $this->isCurrentPlan($plan->id) ? 'ring-2 ring-green-500 bg-green-50 dark:bg-green-900/10' : '' }}">
                        @if ($this->isCurrentPlan($plan->id))
                            <div class="absolute top-4 right-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{-- <x-filament::badge :icon="Heroicon::Check">
                                        Active
                                    </x-filament::badge> --}}
                                    Active

                                </span>
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="text-center mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $plan->name }}
                                </h3>
                                <div class="flex items-center justify-center gap-1 mb-4">
                                    <span class="text-3xl font-bold text-primary-600">
                                        {{ number_format($plan->price / 100, 2) }}
                                    </span>
                                    <img src="{{ asset('images/Saudi_Riyal_Symbol-1.png') }}" width="24"
                                        height="24" alt="SAR" class="opacity-80">
                                    <span class="text-gray-500 dark:text-gray-400">/month</span>
                                </div>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-sm text-gray-600 dark:text-gray-300">{{ $plan->description }}</span>
                                </div>
                            </div>

                            @if ($this->isCurrentPlan($plan->id))
                                <x-filament::button color="success" size="lg" class="w-full"
                                    icon="heroicon-o-check-circle" disabled>
                                    Current Plan
                                </x-filament::button>
                            @else
                                <x-filament::button wire:click="selectPlan({{ $plan->id }})" color="primary"
                                    size="lg" class="w-full" icon="heroicon-o-credit-card">
                                    Choose Plan
                                </x-filament::button>
                            @endif
                        </div>
                    </x-filament::card>
                @endforeach
            </div>
        @else
            {{-- Payment Form --}}
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <x-filament::button wire:click="backToPlans" variant="outline" icon="heroicon-o-arrow-left">
                        Back to Plans
                    </x-filament::button>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Complete Your Payment
                    </h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Plan Summary --}}
                    <x-filament::card>
                        <x-slot name="heading" class="flex items-center gap-2">
                            🔒
                            Order Summary
                        </x-slot>

                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Plan</span>
                                <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $selectedPlan->name }}</span>
                            </div>

                            <div
                                class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Billing Cycle</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Monthly</span>
                            </div>

                            <div
                                class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-300">Price</span>
                                <div class="flex items-center gap-1">
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($selectedPlan->price / 100, 2) }}
                                    </span>
                                    <img src="{{ asset('images/Saudi_Riyal_Symbol-1.png') }}" width="16"
                                        height="16" alt="SAR" class="opacity-80">
                                </div>
                            </div>

                            <div class="flex items-center justify-between py-3 text-lg font-bold">
                                <span class="text-gray-900 dark:text-white">Total</span>
                                <div class="flex items-center gap-1">
                                    <span class="text-primary-600">
                                        {{ number_format($selectedPlan->price / 100, 2) }}
                                    </span>
                                    <img src="{{ asset('images/Saudi_Riyal_Symbol-1.png') }}" width="16"
                                        height="16" alt="SAR" class="opacity-80">
                                </div>
                            </div>
                        </div>
                    </x-filament::card>

                    {{-- Payment Button --}}
                    <x-filament::card>
                        <x-slot name="heading" class="flex items-center gap-2">
                            ✅
                            Secure Payment
                        </x-slot>

                        <div class="space-y-6">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    ✅ Secure Payment Gateway
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    You will be redirected to Moyasar's secure payment form to complete your purchase.
                                </p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    🔒
                                    <span class="text-sm text-blue-700 dark:text-blue-300">SSL Encrypted</span>
                                </div>

                                <div class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    🔒
                                    <span class="text-sm text-blue-700 dark:text-blue-300">PCI DSS Compliant</span>
                                </div>

                                <div class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    🔒
                                    <span class="text-sm text-blue-700 dark:text-blue-300">No card data stored</span>
                                </div>
                            </div>

                            {{-- Payment Error --}}
                            @error('payment')
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4">
                                    <p class="text-red-700 dark:text-red-300 text-sm">{{ $message }}</p>
                                </div>
                            @enderror

                            {{-- Submit Button --}}
                            <x-filament::button wire:click="processPayment" color="primary" size="lg"
                                class="w-full" icon="heroicon-o-credit-card" wire:loading.attr="disabled"
                                wire:loading.class="opacity-50">
                                <span wire:loading.remove>Pay {{ number_format($selectedPlan->price / 100, 2) }}
                                    SAR</span>
                                <span wire:loading>Processing...</span>
                            </x-filament::button>
                        </div>
                    </x-filament::card>
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
