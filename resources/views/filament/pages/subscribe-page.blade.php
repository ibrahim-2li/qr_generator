<x-filament::page>
    <div class="max-w-6xl mx-auto space-y-8">
        @if (!$showPaymentForm)
            {{-- Plans Selection --}}
            <div>
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">
                    Choose a subscription plan 💳
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->plans as $plan)
                    <x-filament::card class="relative overflow-hidden hover:shadow-lg transition-shadow">
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
                                    {{-- <svg src="{{ asset('svg/x.svg') }}" width="24" height="24"></svg> --}}

                                    <span
                                        class="text-sm text-gray-600 dark:text-gray-300">{{ $plan->description }}</span>
                                </div>
                            </div>

                            <x-filament::button wire:click="selectPlan({{ $plan->id }})" color="primary"
                                size="lg" class="w-full" icon="heroicon-o-credit-card">
                                Choose Plan
                            </x-filament::button>
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
