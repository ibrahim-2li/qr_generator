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
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01" />
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
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scans_by_region') }}
                </h3>
                <div class="h-48">
                    <canvas id="regionChart"></canvas>
                </div>
            </div>

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
