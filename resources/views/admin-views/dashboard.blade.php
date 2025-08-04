<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="space-y-6">
        <!-- Overview Cards - Existing Top Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-blue-500">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Books</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">@isset($totalBooks){{ $totalBooks }}@else 0 @endisset</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div
                class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-green-500">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Members</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">@isset($totalMembers){{ $totalMembers }}@else 0 @endisset</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M9 20v-2a3 3 0 00-3-3H4a3 3 0 00-3 3v2.5M17 9a2 2 0 11-4 0 2 2 0 014 0zM7 13a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            {{-- Borrowed Books Card --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-yellow-500">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Books Borrowed</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">@isset($booksBorrowed){{ $booksBorrowed }}@else 0 @endisset</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10l7.89-3.95A2 2 0 0112 6c.74 0 1.45.3 1.95.8L21 10M3 10V4a2 2 0 012-2h14a2 2 0 012 2v6M3 10h18" />
                </svg>
            </div>

            {{-- Overdue Books Card - This one will wrap to the next row on lg screens --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-red-500">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Overdue Books</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">@isset($overdueBooks){{ $overdueBooks }}@else 0 @endisset</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>



        <!-- Dashboard Content Sections - Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Recent Activity Feed (Left Column) -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h3>
                @if ($recentActivities->isEmpty())
                    <p class="text-gray-600">No recent activity to display.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($recentActivities as $activity)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        {{-- Dynamic icons based on activity type for better visual cues --}}
                                        @if ($activity['type'] == 'loan')
                                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10l7.89-3.95A2 2 0 0112 6c.74 0 1.45.3 1.95.8L21 10M3 10V4a2 2 0 012-2h14a2 2 0 012 2v6M3 10h18"></path></svg>
                                        @elseif ($activity['type'] == 'return')
                                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @elseif ($activity['type'] == 'fine_issued')
                                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9v2a4 4 0 01-4 4H7a4 4 0 01-4-4V9m14 0a4 4 0 00-4-4H7a4 4 0 00-4 4m0 0v10a2 2 0 002 2h10a2 2 0 002-2V9m-7 5h.01"></path></svg>
                                        @elseif ($activity['type'] == 'fine_paid')
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $activity['description'] }}
                                        </p>
                                        {{-- Link to relevant management page --}}
                                        <p class="text-sm text-gray-500">
                                            <a href="{{ $activity['link'] }}" class="text-blue-500 hover:underline">View Details</a>
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-sm text-gray-500">
                                        {{ $activity['date']->diffForHumans() }} {{-- Displays "X minutes ago", "Y days ago" --}}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Overdue Books Spotlight (Right Column on lg, below activity on md) -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Critical Overdue Books</h3>
                @if ($criticalOverdueBooks->isEmpty())
                    <p class="text-gray-600">No critically overdue books at the moment. Great job!</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($criticalOverdueBooks as $loan)
                            <li class="py-3">
                                <p class="text-sm font-medium text-gray-900">
                                    "{{ $loan->book->title ?? 'N/A' }}"
                                </p>
                                <p class="text-xs text-gray-600">
                                    Borrowed by: {{ $loan->user->name ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-red-600 font-semibold">
                                    Overdue by: {{ floor($loan->due_date->diffInDays(Carbon\Carbon::now())) }} days
                                </p>
                                <a href="{{ route('admin.loans') }}" class="text-blue-500 text-sm hover:underline">Manage Loan</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Books Nearing Due Date (This will now stack below the first two on lg screens) -->
            <div class=" bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Books Nearing Due Date</h3>
                @if ($nearingDueBooks->isEmpty())
                    <p class="text-gray-600">No books due in the next 3 days.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($nearingDueBooks as $loan)
                            <li class="py-3">
                                <p class="text-sm font-medium text-gray-900">
                                    "{{ $loan->book->title ?? 'N/A' }}"
                                </p>
                                <p class="text-xs text-gray-600">
                                    Borrowed by: {{ $loan->user->name ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-yellow-600 font-semibold">
                                    Due: {{ $loan->due_date->format('M d, Y') }}
                                </p>
                                <a href="{{ route('admin.loans') }}" class="text-blue-500 text-sm hover:underline">Manage Loan</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>


        <!-- Borrowing Trends Graph Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Borrowing Trends (Last 30 Days)</h3>
            <div class="relative h-80"> {{-- fixed height for the canvas container --}}
                <canvas id="borrowingChart"></canvas>
            </div>
        </div>

    </div>


    @push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // Check if Chart.js is loaded to prevent errors
            if (typeof Chart === 'undefined') {
                console.error("Chart.js is not loaded. Please ensure the Chart.js script is included in your layout.");
            } else {
                // Get the canvas element for the chart
                const ctx = document.getElementById('borrowingChart').getContext('2d');

                // Parse the JSON data passed from the Laravel controller
                const chartLabels = {!! $chartLabels !!};
                const chartData = {!! $chartData !!};

                // Create the Chart.js instance
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Books Borrowed',
                            data: chartData,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Books'
                                },
                                ticks: {
                                    precision: 0
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        }
                    }
                });
            }
        </script>
    @endpush
</x-admin-layout>
