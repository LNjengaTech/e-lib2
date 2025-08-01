<x-admin-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="space-y-6">
        <!-- Overview Cards -->
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
            <div
                class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-yellow-500">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Books Borrowed</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">@isset($booksBorrowed){{ $booksBorrowed }}@else 0 @endisset</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between border-l-4 border-red-500">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Overdue Books</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">@isset($overdueBooks){{ $overdueBooks }}@else 0 @endisset</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Charts and Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Daily Visitors Chart (Placeholder) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Daily Visitors</h3>
                <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                    [Chart Placeholder - e.g., using Chart.js or D3.js later]
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Recent Activity</h3>
                <ul class="divide-y divide-gray-200">
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Book: "The Laravel Way"</p>
                            <p class="text-xs text-gray-500">Borrowed by: John Doe (ID: 1001)</p>
                        </div>
                        <span class="text-xs text-gray-600">5 mins ago</span>
                    </li>
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Book: "PHP for Beginners"</p>
                            <p class="text-xs text-gray-500">Returned by: Jane Smith (ID: 1002)</p>
                        </div>
                        <span class="text-xs text-gray-600">1 hour ago</span>
                    </li>
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Book: "Database Design"</p>
                            <p class="text-xs text-gray-500">Reserved by: Peter Jones (ID: 1003)</p>
                        </div>
                        <span class="text-xs text-gray-600">3 hours ago</span>
                    </li>
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Fine Issued: $5.00</p>
                            <p class="text-xs text-gray-500">To: Alice Brown (ID: 1004) for "Overdue Book"</p>
                        </div>
                        <span class="text-xs text-gray-600">Yesterday</span>
                    </li>
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">New Book Added: "Vue.js Mastery"</p>
                            <p class="text-xs text-gray-500">By: Librarian Admin</p>
                        </div>
                        <span class="text-xs text-gray-600">2 days ago</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Books by Category Chart and Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Books by Category Chart (Placeholder) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Books by Category</h3>
                <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                    [Chart Placeholder - e.g., using Chart.js or D3.js later]
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.books') }}"
                        class="flex flex-col items-center justify-center p-4 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600 transition duration-150 ease-in-out text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="text-sm font-medium">Manage Books</span>
                    </a>
                    <a href="{{ route('admin.loans') }}"
                        class="flex flex-col items-center justify-center p-4 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition duration-150 ease-in-out text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        <span class="text-sm font-medium">View Loans</span>
                    </a>
                    <a href="{{ route('admin.fines') }}"
                        class="flex flex-col items-center justify-center p-4 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition duration-150 ease-in-out text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-sm font-medium">Manage Fines</span>
                    </a>
                    <button
                        class="flex flex-col items-center justify-center p-4 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition duration-150 ease-in-out text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Generate Report</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
