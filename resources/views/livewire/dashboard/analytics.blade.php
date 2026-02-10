<div>
    <div class="space-y-6">
        <!-- Header with Filter -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('dashboard.analytics_title') }}</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    {{ __('dashboard.analytics_description') }}
                </p>
            </div>

            <!-- QR Code Filter -->
            <div class="w-full sm:w-64">
                <label for="qrCodeFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ __('dashboard.filter_by_qr_code') }}
                </label>
                <select wire:model.live="selectedQrCodeId" id="qrCodeFilter"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    <option value="">{{ __('dashboard.all_qr_codes') }}</option>
                    @foreach ($qrCodeOptions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total QR Codes -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg viewBox="0 0 28 28" class="h-6 w-6" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                <title>ic_fluent_qr_code_24_regular</title>
                                <desc>Created with Sketch.</desc>
                                <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <g id="ic_fluent_qr_code_24_regular" fill="#1a3be0" fill-rule="nonzero">
                                        <path
                                            d="M10.75,15 C11.9926407,15 13,16.0073593 13,17.25 L13,22.75 C13,23.9926407 11.9926407,25 10.75,25 L5.25,25 C4.00735931,25 3,23.9926407 3,22.75 L3,17.25 C3,16.0073593 4.00735931,15 5.25,15 L10.75,15 Z M18.3346843,15 L18.3346843,18.3333333 L21.6671089,18.3333333 L21.6671089,21.6666667 L18.3346843,21.6660851 L18.3346843,24.9994184 L15.0013509,24.9994184 L15.0013509,21.6660851 L18.3337756,21.6666667 L18.3337756,18.3333333 L15.0013509,18.3333333 L15.0013509,15 L18.3346843,15 Z M25.0004423,21.6660851 L25.0004423,24.9994184 L21.6671089,24.9994184 L21.6671089,21.6660851 L25.0004423,21.6660851 Z M10.75,16.5 L5.25,16.5 C4.83578644,16.5 4.5,16.8357864 4.5,17.25 L4.5,22.75 C4.5,23.1642136 4.83578644,23.5 5.25,23.5 L10.75,23.5 C11.1642136,23.5 11.5,23.1642136 11.5,22.75 L11.5,17.25 C11.5,16.8357864 11.1642136,16.5 10.75,16.5 Z M9.5,18.5 L9.5,21.5 L6.5,21.5 L6.5,18.5 L9.5,18.5 Z M25.0004423,15 L25.0004423,18.3333333 L21.6671089,18.3333333 L21.6671089,15 L25.0004423,15 Z M10.75,3 C11.9926407,3 13,4.00735931 13,5.25 L13,10.75 C13,11.9926407 11.9926407,13 10.75,13 L5.25,13 C4.00735931,13 3,11.9926407 3,10.75 L3,5.25 C3,4.00735931 4.00735931,3 5.25,3 L10.75,3 Z M22.75,3 C23.9926407,3 25,4.00735931 25,5.25 L25,10.75 C25,11.9926407 23.9926407,13 22.75,13 L17.25,13 C16.0073593,13 15,11.9926407 15,10.75 L15,5.25 C15,4.00735931 16.0073593,3 17.25,3 L22.75,3 Z M10.75,4.5 L5.25,4.5 C4.83578644,4.5 4.5,4.83578644 4.5,5.25 L4.5,10.75 C4.5,11.1642136 4.83578644,11.5 5.25,11.5 L10.75,11.5 C11.1642136,11.5 11.5,11.1642136 11.5,10.75 L11.5,5.25 C11.5,4.83578644 11.1642136,4.5 10.75,4.5 Z M22.75,4.5 L17.25,4.5 C16.8357864,4.5 16.5,4.83578644 16.5,5.25 L16.5,10.75 C16.5,11.1642136 16.8357864,11.5 17.25,11.5 L22.75,11.5 C23.1642136,11.5 23.5,11.1642136 23.5,10.75 L23.5,5.25 C23.5,4.83578644 23.1642136,4.5 22.75,4.5 Z M9.5,6.5 L9.5,9.5 L6.5,9.5 L6.5,6.5 L9.5,6.5 Z M21.5,6.5 L21.5,9.5 L18.5,9.5 L18.5,6.5 L21.5,6.5 Z"
                                            id="🎨-Color"> </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.total_qr_codes') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalQrCodes) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $selectedQrCodeId ? __('dashboard.selected_qr_code') : __('dashboard.all_qr_codes_created') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Scans -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.total_scans') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalScans) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('dashboard.all_scan_events') }}</p>
                    </div>
                </div>
            </div>

            <!-- Unique Scans -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('dashboard.unique_scans') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($uniqueScans) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('dashboard.unique_ip_addresses') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Scans by Country -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scans_by_country') }}
                </h3>
                <div class="h-48">
                    <canvas id="countryChart"></canvas>
                </div>
            </div>

            <!-- Scans by Region -->
            {{-- <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scans_by_region') }}
                </h3>
                <div class="h-48">
                    <canvas id="regionChart"></canvas>
                </div>
            </div> --}}

            <!-- Scans by City -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scans_by_city') }}
                </h3>
                <div class="h-48">
                    <canvas id="cityChart"></canvas>
                </div>
            </div>

            <!-- Scans by Device -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scans_by_device') }}
                </h3>
                <div class="h-48">
                    <canvas id="deviceChart"></canvas>
                </div>
            </div>

            <!-- Scans by OS -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scans_by_os') }}
                </h3>
                <div class="h-48">
                    <canvas id="osChart"></canvas>
                </div>
            </div>

            <!-- Scan Trends (Bar) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scan_trends_bar') }}
                </h3>
                <div class="h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Scan Trends (Line) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scan_trends_line') }}
                </h3>
                <div class="h-64">
                    <canvas id="trendLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@assets
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
    <script>
        let charts = {};

        const colors = [
            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
            '#EC4899', '#6366F1', '#14B8A6', '#F97316', '#64748B'
        ];

        function createPieChart(id, label, data) {
            const ctx = document.getElementById(id);
            if (!ctx) return;

            if (charts[id]) {
                charts[id].destroy();
            }

            const labels = Object.keys(data);
            const values = Object.values(data);

            // Handle empty data
            if (labels.length === 0) {
                // Optional: Draw 'No Data' placeholder or handle appropriately
                return;
            }

            charts[id] = new Chart(ctx, {
                type: 'pie', // Changed to pie as requested
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: values,
                        backgroundColor: colors.slice(0, values.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#374151'
                            }
                        }
                    }
                }
            });
        }

        function createBarChart(id, label, data) {
            const ctx = document.getElementById(id);
            if (!ctx) return;

            if (charts[id]) {
                charts[id].destroy();
            }

            const labels = Object.keys(data);
            const values = Object.values(data);

            charts[id] = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: values,
                        backgroundColor: '#F97316',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB'
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#374151'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#374151'
                            }
                        }
                    }
                }
            });
        }

        function initCharts() {
            createPieChart('countryChart', '{{ __('dashboard.scans_by_country') }}', $wire.scansByCountry);
            createPieChart('regionChart', '{{ __('dashboard.scans_by_region') }}', $wire.scansByRegion);
            createPieChart('cityChart', '{{ __('dashboard.scans_by_city') }}', $wire.scansByCity);
            createPieChart('deviceChart', '{{ __('dashboard.scans_by_device') }}', $wire.scansByDevice);
            createPieChart('osChart', '{{ __('dashboard.scans_by_os') }}', $wire.scansByOs);
            createBarChart('trendChart', '{{ __('dashboard.scan_trends') }}', $wire.scanTrendsByDay);
            createLineChart('trendLineChart', '{{ __('dashboard.scan_trends') }}', $wire.scanTrendsByDay);
        }

        function createLineChart(id, label, data) {
            const ctx = document.getElementById(id);
            if (!ctx) return;

            if (charts[id]) {
                charts[id].destroy();
            }

            const labels = Object.keys(data);
            const values = Object.values(data);

            charts[id] = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: values,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB'
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#374151',
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#9CA3AF' : '#374151'
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        }

        // Initialize charts on load
        initCharts();

        // Re-initialize when Livewire updates (e.g., filter change)
        Livewire.hook('morph.updated', ({
            el,
            component
        }) => {
            initCharts();
        });
    </script>
@endscript
