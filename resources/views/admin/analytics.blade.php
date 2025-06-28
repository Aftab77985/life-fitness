<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight tracking-wide">
            📊 {{ __('Analytics') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6 sm:space-y-8">  <!-- Responsive vertical spacing -->

            <!-- Pie Chart Row -->
            <div class="w-full flex justify-center mb-8">
                <div class="bg-white p-6 rounded-xl shadow flex flex-col items-center w-full max-w-md">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🟢 Members & Renewals Overview</h3>
                    <canvas id="pieChart" width="320" height="220"></canvas>
                </div>
            </div>

            <!-- Charts Row (Always in a row, scrollable on mobile) -->
            <div class="w-full overflow-x-auto">
                <div class="grid grid-cols-2 gap-6 min-w-[700px]">
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">📈 New Members per Month</h3>
                        <canvas id="membersChart" height="50"></canvas>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">💰 Revenue per Month</h3>
                        <canvas id="revenueChart" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js + Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script>
        const chartLabels = @json($chartLabels);
        const chartMembers = @json($chartMembers);
        const chartRevenue = @json($chartRevenue);

        // Members Chart
        new Chart(document.getElementById('membersChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'New Members',
                    data: chartMembers,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    hoverBackgroundColor: 'rgba(59, 130, 246, 1)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { enabled: true } },
                animation: { 
                    duration: 1200,  // Increased duration
                    easing: 'easeOutQuart'  // Smoother animation
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' } }
                }
            }
        });

        // Revenue Chart
        new Chart(document.getElementById('revenueChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Revenue (₨)',
                    data: chartRevenue,
                    backgroundColor: 'rgba(236, 72, 153, 0.7)',
                    hoverBackgroundColor: 'rgba(236, 72, 153, 1)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { enabled: true } },
                animation: { 
                    duration: 1200,  // Increased duration
                    easing: 'easeOutQuart'  // Smoother animation
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            callback: function(value) {
                                return '₨' + value;  // Consistent currency symbol
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart Data
        const pieLabels = [
            'Total Members',
            'Active Members',
            'Total Renewals'
        ];
        const pieData = [
            {{ $totalMembers ?? 0 }},
            {{ $activeMembers ?? 0 }},
            {{ $totalRenewals ?? 0 }}
        ];
        const pieColors = [
            'rgba(59, 130, 246, 0.7)', // blue
            'rgba(16, 185, 129, 0.7)', // green
            'rgba(236, 72, 153, 0.7)'  // pink
        ];
        new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: pieColors,
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { enabled: true }
                }
            }
        });
    </script>
</x-app-layout>