@extends('admin.loyout.master')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
        .stat-icon {
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
        }
        .table-row-hover {
            transition: all 0.2s ease;
        }
        .table-row-hover:hover {
            background: linear-gradient(90deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%);
        }
        .progress-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }
        .badge-pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 0.8; }
            50% { opacity: 1; }
            100% { opacity: 0.8; }
        }
        .glow-effect {
            box-shadow: 0 0 30px rgba(102,126,234,0.15);
        }
        .border-gradient {
            border-image: linear-gradient(135deg, #667eea, #764ba2) 1;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }
        .chart-container {
            position: relative;
            height: 300px;
        }
        .glass-morphism {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .stat-value {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>

    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">HealthAnalytics</h1>
                        <p class="text-xs text-gray-500">Disease Management System</p>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-2 bg-gray-100 px-4 py-2 rounded-lg">
                        <i class="far fa-calendar-alt text-gray-500"></i>
                        <span class="text-sm text-gray-600">{{ date('F Y') }}</span>
                    </div>
                    <div class="relative">
                        <button class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=667eea&color=fff&size=40" alt="Admin" class="w-10 h-10 rounded-full border-2 border-purple-500">
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">Admin User</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        <!-- Quick Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm card-hover p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Patients</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalPatients }}</p>
                        <p class="text-xs text-green-500 mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>12.5% this month
                        </p>
                    </div>
                    <div class="w-14 h-14 stat-icon rounded-2xl flex items-center justify-center bg-blue-50">
                        <i class="fas fa-users text-2xl text-blue-500"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full progress-bar" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm card-hover p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Diabetes</p>
                        <p class="text-3xl font-bold text-red-600">{{ $diabetes }}</p>
                        <p class="text-xs text-red-500 mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>8.3% increase
                        </p>
                    </div>
                    <div class="w-14 h-14 stat-icon rounded-2xl flex items-center justify-center bg-red-50">
                        <i class="fas fa-droplet text-2xl text-red-500"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full bg-red-500" style="width: {{ $totalPatients > 0 ? ($diabetes / $totalPatients * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm card-hover p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Hypertension</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $hypertension }}</p>
                        <p class="text-xs text-yellow-500 mt-2">
                            <i class="fas fa-arrow-down mr-1"></i>3.1% decrease
                        </p>
                    </div>
                    <div class="w-14 h-14 stat-icon rounded-2xl flex items-center justify-center bg-yellow-50">
                        <i class="fas fa-heart text-2xl text-yellow-500"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full bg-yellow-500" style="width: {{ $totalPatients > 0 ? ($hypertension / $totalPatients * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm card-hover p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Obesity</p>
                        <p class="text-3xl font-bold text-green-600">{{ $obesity }}</p>
                        <p class="text-xs text-green-500 mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>5.7% increase
                        </p>
                    </div>
                    <div class="w-14 h-14 stat-icon rounded-2xl flex items-center justify-center bg-green-50">
                        <i class="fas fa-weight text-2xl text-green-500"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full bg-green-500" style="width: {{ $totalPatients > 0 ? ($obesity / $totalPatients * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm card-hover p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Infection</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $infection }}</p>
                        <p class="text-xs text-purple-500 mt-2">
                            <i class="fas fa-arrow-up mr-1"></i>2.4% increase
                        </p>
                    </div>
                    <div class="w-14 h-14 stat-icon rounded-2xl flex items-center justify-center bg-purple-50">
                        <i class="fas fa-bacteria text-2xl text-purple-500"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full bg-purple-500" style="width: {{ $totalPatients > 0 ? ($infection / $totalPatients * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Disease Distribution</h2>
                        <p class="text-sm text-gray-500">Current disease prevalence</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-medium">2026</span>
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-medium">Q2</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="diseaseChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Monthly Patient Trend</h2>
                        <p class="text-sm text-gray-500">Patient volume over time</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs font-medium hover:bg-blue-700 transition">Year</button>
                        <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium hover:bg-gray-200 transition">Month</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Monthly Disease Summary</h2>
                    <p class="text-sm text-gray-500">Complete overview by month</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition flex items-center">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                    <button class="px-4 py-2 gradient-bg text-white rounded-lg text-sm font-medium hover:opacity-90 transition flex items-center">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Month
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-users mr-2 text-gray-400"></i>Total
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-droplet mr-2 text-red-400"></i>Diabetes
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-heart mr-2 text-yellow-400"></i>Hypertension
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-weight mr-2 text-green-400"></i>Obesity
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-bacteria mr-2 text-purple-400"></i>Infection
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-percentage mr-2 text-gray-400"></i>Prevalence
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($monthlyTrend as $index => $trend)
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ ['bg-blue-50', 'bg-indigo-50', 'bg-purple-50', 'bg-pink-50', 'bg-red-50', 'bg-orange-50', 'bg-yellow-50', 'bg-green-50', 'bg-teal-50', 'bg-cyan-50', 'bg-sky-50', 'bg-violet-50'][$index % 12] }}">
                                            <span class="text-xs font-bold text-gray-700">{{ $index + 1 }}</span>
                                        </div>
                                        <span class="ml-3 text-sm font-semibold text-gray-800">
                                            {{ DateTime::createFromFormat('!m', $trend->month)->format('F') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                        {{ $trend->total }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                                    {{ $trend->diabetes_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-yellow-600">
                                    {{ $trend->hypertension_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                    {{ $trend->obesity_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600">
                                    {{ $trend->infection_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="h-2 rounded-full progress-bar" style="width: {{ $trend->prevalence_percentage }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700">
                                            {{ $trend->prevalence_percentage }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
                                    No data available for the selected period
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50">
                <p class="text-sm text-gray-600">
                    Showing <span class="font-semibold">{{ count($monthlyTrend) }}</span> months
                </p>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm font-medium">1</span>
                    <button class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-400">
                <i class="far fa-copyright mr-1"></i> {{ date('Y') }} HealthAnalytics. All rights reserved.
                <span class="mx-2">•</span>
                <i class="fas fa-chart-line mr-1 text-green-400"></i> Real-time analytics
                <span class="mx-2">•</span>
                <i class="fas fa-shield-alt mr-1 text-blue-400"></i> Secure & encrypted
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Disease Distribution Chart - Doughnut
            const diseaseCtx = document.getElementById('diseaseChart').getContext('2d');
            new Chart(diseaseCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Diabetes', 'Hypertension', 'Obesity', 'Infection'],
                    datasets: [{
                        data: [
                            {{ $diabetes }},
                            {{ $hypertension }},
                            {{ $obesity }},
                            {{ $infection }}
                        ],
                        backgroundColor: [
                            '#EF4444',
                            '#F59E0B',
                            '#10B981',
                            '#8B5CF6'
                        ],
                        borderWidth: 3,
                        borderColor: '#FFFFFF',
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });

            // Monthly Trend Chart - Line
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const monthlyData = @json($monthlyTrend);

            const gradient = trendCtx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
            gradient.addColorStop(1, 'rgba(118, 75, 162, 0.05)');

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => {
                        const date = new Date(2024, item.month - 1, 1);
                        return date.toLocaleString('default', { month: 'short' });
                    }),
                    datasets: [{
                        label: 'Total Patients',
                        data: monthlyData.map(item => item.total),
                        borderColor: '#667eea',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#764ba2'
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
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleFont: {
                                size: 13,
                                weight: '600'
                            },
                            bodyFont: {
                                size: 12
                            },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 11,
                                    weight: '500'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11,
                                    weight: '500'
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        });
    </script>
@endsection
