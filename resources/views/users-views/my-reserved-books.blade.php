{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Borrowed and Reserved Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">This page will show all books you have currently borrowed or reserved.</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book Title</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Author</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due/Pickup Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">The Great Novel</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Jane Doe</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600">Borrowed</td>
                                    <td class="px-6 py-4 whitespace-nowrap">2025-08-15</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Another Story</td>
                                    <td class="px-6 py-4 whitespace-nowrap">John Smith</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-yellow-600">Reserved</td>
                                    <td class="px-6 py-4 whitespace-nowrap">2025-07-24 (Pickup Deadline)</td>
                                </tr>
                                <!-- More rows will be added dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <p class="mt-6 text-sm text-gray-500">Note: This table will be populated with your actual borrowed
                        and reserved books once the backend logic is implemented.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.user')
@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p class="mb-4">This page shows all books you have currently borrowed</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Book Title</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Author</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Due/Pickup Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($reservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->catalogue->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->catalogue->author }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-{{ $reservation->status === 'pending' ? 'yellow' : 'green-600' }}">
                                        {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($reservation->status === 'pending')
                                            {{ \Carbon\Carbon::parse($reservation->expires_at)->format('Y-m-d') }} (Pickup
                                            Deadline)
                                        @elseif($reservation->status === 'confirmed_pickup')
                                            {{ \Carbon\Carbon::parse($reservation->reserved_at)->addDays(14)->format('Y-m-d') }}
                                            (Due)
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">You have no active
                                        reservations or borrowed books.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
