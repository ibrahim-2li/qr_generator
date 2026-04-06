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
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
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

        <!-- Donut Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


            <!-- Scans by QR Code Name -->
            {{-- <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
                x-data="{ showPercentage: true }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('dashboard.scans_by_qr_code') }}
                    </h3>
                    <div class="flex items-center gap-1">
                        <button @click="showPercentage = true"
                            :class="showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">%</button>
                        <button @click="showPercentage = false"
                            :class="!showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">##</button>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0" style="width: 140px; height: 140px;">
                        <canvas id="qrCodeChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalScans }}</span>
                        </div>
                    </div>
                    <div class="flex-1 space-y-2 min-w-0" id="qrCodeLegend"></div>
                </div>
            </div> --}}

            <!-- Scans by Country -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
                x-data="{ showPercentage: true }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('dashboard.scans_by_country') }}
                    </h3>
                    <div class="flex items-center gap-1">
                        <button @click="showPercentage = true"
                            :class="showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">%</button>
                        <button @click="showPercentage = false"
                            :class="!showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">##</button>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0" style="width: 140px; height: 140px;">
                        <canvas id="countryChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalScans }}</span>
                        </div>
                    </div>
                    <div class="flex-1 space-y-2 min-w-0" id="countryLegend"></div>
                </div>
            </div>

            <!-- Scans by City -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
                x-data="{ showPercentage: true }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('dashboard.scans_by_city') }}
                    </h3>
                    <div class="flex items-center gap-1">
                        <button @click="showPercentage = true"
                            :class="showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">%</button>
                        <button @click="showPercentage = false"
                            :class="!showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">##</button>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0" style="width: 140px; height: 140px;">
                        <canvas id="cityChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalScans }}</span>
                        </div>
                    </div>
                    <div class="flex-1 space-y-2 min-w-0" id="cityLegend"></div>
                </div>
            </div>

            <!-- Scans by Operating System -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
                x-data="{ showPercentage: true }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('dashboard.scans_by_operating_system') }}
                    </h3>
                    <div class="flex items-center gap-1">
                        <button @click="showPercentage = true"
                            :class="showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">%</button>
                        <button @click="showPercentage = false"
                            :class="!showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">##</button>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0" style="width: 140px; height: 140px;">
                        <canvas id="osChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalScans }}</span>
                        </div>
                    </div>
                    <div class="flex-1 space-y-2 min-w-0" id="osLegend"></div>
                </div>
            </div>

            <!-- Scans by Device -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
                x-data="{ showPercentage: true }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('dashboard.scans_by_device') }}
                    </h3>
                    <div class="flex items-center gap-1">
                        <button @click="showPercentage = true"
                            :class="showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">%</button>
                        <button @click="showPercentage = false"
                            :class="!showPercentage ? 'bg-blue-500 text-white' :
                                'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400'"
                            class="px-2.5 py-1 rounded-md text-xs font-semibold transition-colors">##</button>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative shrink-0" style="width: 140px; height: 140px;">
                        <canvas id="deviceChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalScans }}</span>
                        </div>
                    </div>
                    <div class="flex-1 space-y-2 min-w-0" id="deviceLegend"></div>
                </div>
            </div>

        </div>

        <!-- Trend Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


            <!-- Scan Trends (Bar) -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">
                    {{ __('dashboard.scan_trends_bar') }}
                </h3>
                <div class="h-48">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Scan Trends (Line) -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 ">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">
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
            '#4F7BF7', '#F5A623', '#10B981', '#EF4444', '#8B5CF6',
            '#EC4899', '#6366F1', '#14B8A6', '#F97316', '#64748B'
        ];

        function buildCustomLegend(containerId, labels, values, chartColors) {
            const container = document.getElementById(containerId);
            if (!container) return;

            const total = values.reduce((a, b) => a + b, 0);
            container.innerHTML = '';

            labels.forEach((label, i) => {
                const pct = total > 0 ? ((values[i] / total) * 100).toFixed(1) : 0;
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between gap-3';
                row.innerHTML = `
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="inline-block w-2.5 h-2.5 rounded-full shrink-0" style="background-color: ${chartColors[i % chartColors.length]}"></span>
                        <span class="text-sm text-gray-700 dark:text-gray-300 truncate">${label || 'Unknown'}</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white shrink-0 legend-value" data-pct="${pct}%" data-count="${values[i]}">${pct}%</span>
                `;
                container.appendChild(row);
            });
        }

        function createDonutChart(id, legendId, data) {
            const ctx = document.getElementById(id);
            if (!ctx) return;

            if (charts[id]) {
                charts[id].destroy();
            }

            const labels = Object.keys(data);
            const values = Object.values(data);

            // Handle empty data
            if (labels.length === 0) {
                const legendContainer = document.getElementById(legendId);
                if (legendContainer) {
                    legendContainer.innerHTML =
                        '<p class="text-sm text-gray-400 dark:text-gray-500">{{ __('dashboard.no_data') }}</p>';
                }
                // Draw empty ring
                charts[id] = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['No data'],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#E5E7EB'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    }
                });
                return;
            }

            const chartColors = colors.slice(0, values.length);

            charts[id] = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: chartColors,
                        borderWidth: 2,
                        borderColor: document.documentElement.classList.contains('dark') ? '#1F2937' :
                            '#FFFFFF',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#FFFFFF',
                            titleColor: '#374151',
                            bodyColor: '#374151',
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 10,
                            boxPadding: 5,
                            displayColors: true,
                            callbacks: {
                                label: function(ctx) {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? ((ctx.raw / total) * 100).toFixed(1) : 0;
                                    return `${ctx.label}: ${ctx.raw} scans (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Build the custom legend
            buildCustomLegend(legendId, labels, values, chartColors);
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
                        backgroundColor: '#4F7BF7',
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
                    }
                }
            });
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
                        borderColor: '#4F7BF7',
                        backgroundColor: 'rgba(79, 123, 247, 0.1)',
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

        function initCharts() {
            createDonutChart('osChart', 'osLegend', $wire.scansByOs);
            createDonutChart('qrCodeChart', 'qrCodeLegend', $wire.scansByQrCode);
            createDonutChart('countryChart', 'countryLegend', $wire.scansByCountry);
            createDonutChart('cityChart', 'cityLegend', $wire.scansByCity);
            createDonutChart('deviceChart', 'deviceLegend', $wire.scansByDevice);
            createBarChart('trendChart', '{{ __('dashboard.scan_trends') }}', $wire.scanTrendsByDay);
            createLineChart('trendLineChart', '{{ __('dashboard.scan_trends') }}', $wire.scanTrendsByDay);
        }

        // Toggle between percentage and count display
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[x-data] button');
            if (!btn) return;

            const card = btn.closest('[x-data]');
            if (!card) return;

            // Wait for Alpine state update
            setTimeout(() => {
                const showPct = btn.textContent.trim() === '%';
                const legendContainer = card.querySelector('[id$="Legend"]');
                if (!legendContainer) return;

                legendContainer.querySelectorAll('.legend-value').forEach(el => {
                    if (showPct) {
                        el.textContent = el.dataset.pct;
                    } else {
                        el.textContent = el.dataset.count;
                    }
                });
            }, 50);
        });

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
