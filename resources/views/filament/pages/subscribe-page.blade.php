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
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
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

                    {{-- Payment Form --}}
                    <x-filament::card>
                        <x-slot name="heading" class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                            Payment Information
                        </x-slot>

                        <form wire:submit="processPayment" class="space-y-6">
                            {{-- Card Number --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Card Number
                                </label>
                                <input type="text" wire:model="cardNumber" placeholder="1234 5678 9012 3456"
                                    maxlength="19"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                                    x-data
                                    x-on:input="
                                        $event.target.value = $event.target.value.replace(/\s/g, '').replace(/(.{4})/g, '$1 ').trim();
                                        $wire.cardNumber = $event.target.value.replace(/\s/g, '');
                                    " />
                                @error('cardNumber')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Card Holder Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Card Holder Name
                                </label>
                                <input type="text" wire:model="cardName" placeholder="John Doe"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white" />
                                @error('cardName')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Expiry and CVC Row --}}
                            <div class="grid grid-cols-2 gap-4">
                                {{-- Expiry Month --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Month
                                    </label>
                                    <select wire:model="expiryMonth"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">MM</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('expiryMonth')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Expiry Year --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Year
                                    </label>
                                    <select wire:model="expiryYear"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">YY</option>
                                        @for ($i = date('y'); $i <= date('y') + 10; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('expiryYear')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- CVC --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CVC
                                </label>
                                <input type="text" wire:model="cvc" placeholder="123" maxlength="4"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white" />
                                @error('cvc')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Payment Error --}}
                            @error('payment')
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4">
                                    <p class="text-red-700 dark:text-red-300 text-sm">{{ $message }}</p>
                                </div>
                            @enderror

                            {{-- Submit Button --}}
                            <x-filament::button type="submit" color="primary" size="lg" class="w-full"
                                icon="heroicon-o-credit-card" wire:loading.attr="disabled"
                                wire:loading.class="opacity-50">
                                <span wire:loading.remove>Pay {{ number_format($selectedPlan->price / 100, 2) }}
                                    SAR</span>
                                <span wire:loading>Processing Payment...</span>
                            </x-filament::button>
                        </form>
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
