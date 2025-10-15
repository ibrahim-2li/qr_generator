<x-filament::page>
    <div class="max-w-6xl mx-auto space-y-8">
        @if ($this->subscription)
            {{-- Subscription Details Table --}}
            <x-filament::section heading="Subscription Details" icon="heroicon-o-rectangle-stack" class="overflow-hidden">
                <x-filament::card class="p-0 overflow-hidden">
                    <table class="w-full text-sm text-center">

                        <thead
                            class="flex justify-between px-8 py-8 bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                {{-- <th class="px-6 py-3 font-bold  text-blue-600 dark:text-blue-600 uppercase">
                                    <x-filament::card class="font-bold  text-blue-600 dark:text-blue-600 uppercase">
                                        Details
                                    </x-filament::card>
                                </th> --}}
                                <th class="px-6 py-3 font-bold text-gray-600 dark:text-gray-300 uppercase">
                                    <x-filament::card class="font-bold  text-blue-600 dark:text-blue-600 uppercase">
                                        Information
                                    </x-filament::card>

                                </th>
                                <th class="px-6 py-3 font-bold text-gray-600 dark:text-gray-300 uppercase">
                                    <x-filament::card class="font-bold  text-blue-600 dark:text-blue-600 uppercase">
                                        Status
                                    </x-filament::card>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <style>
                                td::before {
                                    content: ' ';
                                    margin-right: 1.5rem;
                                }
                            </style>
                            {{-- Plan Name --}}
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors ">
                                {{-- <td class="font-semibold text-gray-900 dark:text-white">
                                    <span>
                                        Plan Name
                                    </span>

                                </td> --}}
                                <td class=" font-semibold text-gray-900 dark:text-white">
                                    {{ $this->subscription->plan->name }}
                                </td>
                                <td class="px-6 py-4 ">
                                    <x-filament::badge
                                        color="{{ match ($this->subscription->status) {
                                            'active' => 'success',
                                            'pending' => 'warning',
                                            'canceled' => 'danger',
                                            default => 'gray',
                                        } }}">
                                        {{ ucfirst($this->subscription->status) }}
                                    </x-filament::badge>
                                </td>
                            </tr>

                            {{-- Monthly Price --}}
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                {{-- <td class="px-6 py-4">

                                    <span>
                                        Monthly Price
                                    </span>

                                </td> --}}
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($this->subscription->plan->price / 100, 2) }} SAR
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400"> Monthly Billing</td>
                            </tr>

                            {{-- Start Date --}}
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                {{-- <td class="px-6 py-4">
                                    <span>
                                        Start Date
                                    </span>
                                </td> --}}
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ $this->subscription->starts_at?->format('M d, Y') ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $this->subscription->starts_at?->diffForHumans() ?? 'N/A' }}
                                </td>
                            </tr>

                            {{-- End Date --}}
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                {{-- <td class="px-6 py-4">
                                    <span>
                                        End Date
                                    </span>
                                </td> --}}
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ $this->subscription->ends_at?->format('M d, Y') ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $this->subscription->ends_at?->diffForHumans() ?? 'N/A' }}
                                </td>
                            </tr>

                            {{-- Auto Renewal --}}
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                {{-- <td class="px-6 py-4">
                                    <span>
                                        Auto Renewal
                                    </span>
                                </td> --}}
                                <td class="px-6 py-4">
                                    <x-filament::badge
                                        color="{{ $this->subscription->status === 'active' ? 'success' : 'gray' }}">
                                        {{ $this->subscription->status === 'active' ? 'Enabled' : 'Disabled' }}
                                    </x-filament::badge>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $this->subscription->status === 'active' ? 'Will auto-renew' : 'Manual renewal required' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </x-filament::card>
            </x-filament::section>

            {{-- Action Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Quick Actions --}}
                <x-filament::card class="relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primary-100 to-transparent rounded-full transform translate-x-16 -translate-y-16">
                    </div>

                    <x-slot name="heading" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </x-slot>

                    <div class="space-y-4 relative">
                        @if ($this->subscription->status === 'active')
                            <x-filament::button wire:click="renew" color="success" size="lg"
                                class="w-full justify-start" icon="heroicon-o-arrow-path">
                                Renew Subscription
                            </x-filament::button>
                        @endif

                        @if ($this->subscription->status !== 'canceled')
                            <x-filament::button wire:click="cancel" color="danger" variant="outline" size="lg"
                                class="w-full justify-start" icon="heroicon-o-x-mark">
                                Cancel Subscription
                            </x-filament::button>
                        @endif

                        <x-filament::button
                            onclick="window.location.href = '{{ route('filament.dashboard.pages.subscribe-page') }}'"
                            color="primary" variant="outline" size="lg" class="w-full justify-start"
                            icon="heroicon-o-arrow-right-on-rectangle">
                            Change Plan
                        </x-filament::button>
                    </div>
                </x-filament::card>

                {{-- Plan Details --}}
                <x-filament::card class="relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-success-100 to-transparent rounded-full transform translate-x-16 -translate-y-16">
                    </div>

                    <x-slot name="heading" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Plan Information
                    </x-slot>

                    <div class="space-y-4 relative">
                        <div
                            class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Billing Cycle</span>
                            <span class="font-semibold text-gray-900 dark:text-white">Monthly</span>
                        </div>

                        <div
                            class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Next Billing</span>
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $this->subscription->ends_at?->format('M d, Y') ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Days Remaining</span>
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ (int) now()->diffInDays($this->subscription->ends_at) ?? 'N/A' }} days
                            </span>
                        </div>
                    </div>
                </x-filament::card>
            </div>

            {{-- Payment History --}}
            <x-filament::section heading="Payment History" icon="heroicon-o-credit-card" class="overflow-hidden">
                {{ $this->table }}
            </x-filament::section>
        @else
            {{-- No Subscription State --}}
            <x-filament::card>
                <div class="text-center py-16">
                    <div
                        class="mx-auto w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6">
                        <svg width="30" height="30" viewBox="0 0 200 200" data-name="Layer 1" id="Layer_1"
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
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No Active Subscription</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-8 max-w-md mx-auto">
                        You don't have any active subscription. Choose a plan that fits your needs and start creating
                        amazing QR codes.
                    </p>
                    <a class="fi-color fi-color-primary fi-bg-color-400 hover:fi-bg-color-300 dark:fi-bg-color-600 dark:hover:fi-bg-color-500 fi-text-color-950 hover:fi-text-color-900 dark:fi-text-color-950 dark:hover:fi-text-color-950 fi-btn fi-size-md"
                        href="{{ route('filament.dashboard.pages.subscribe-page') }}" color="primary" size="lg"
                        icon="heroicon-o-plus">
                        + Subscribe Now
                    </a>
                </div>
            </x-filament::card>
        @endif
    </div>
</x-filament::page>
