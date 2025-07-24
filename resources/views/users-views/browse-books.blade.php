<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Browse Available Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">This page will display all available books. You can search and filter them here.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Placeholder for book cards -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h3 class="font-bold text-lg">Book Title 1</h3>
                            <p class="text-sm text-gray-600">Author Name</p>
                            <p class="text-sm mt-2">Status: Available</p>
                            <button
                                class="mt-4 px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Reserve</button>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h3 class="font-bold text-lg">Book Title 2</h3>
                            <p class="text-sm text-gray-600">Author Name</p>
                            <p class="text-sm mt-2">Status: Available</p>
                            <button
                                class="mt-4 px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Reserve</button>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <h3 class="font-bold text-lg">Book Title 3</h3>
                            <p class="text-sm text-gray-600">Author Name</p>
                            <p class="text-sm mt-2">Status: Reserved</p>
                            <button disabled
                                class="mt-4 px-3 py-1 bg-gray-400 text-white rounded-md cursor-not-allowed">Reserved</button>
                        </div>
                    </div>
                    <p class="mt-6 text-sm text-gray-500">Note: Full book details and reservation logic will be added
                        later.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
