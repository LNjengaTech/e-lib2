<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Reservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Manage book reservations. Confirm when a student picks up a reserved book.</p>

                    {{-- Session Messages --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <strong class="font-bold">Warning!</strong>
                            <span class="block sm:inline">{{ session('warning') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        @if ($reservations->isEmpty())
                            <p class="text-gray-600">No reservations to display at the moment.</p>
                        @else
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Book Title</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Reservation Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pickup Deadline</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($reservations as $reservation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $reservation->user->name ?? 'N/A' }}
                                                <br>
                                                <span class="text-xs text-gray-500">Reg:
                                                    {{ $reservation->user->reg_number ?? 'N/A' }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $reservation->catalogue->title ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $reservation->reserved_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $reservation->expires_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if ($reservation->status === 'pending') bg-yellow text-black
                                                            @elseif ($reservation->status === 'confirmed_pickup') bg-green-100 text-green-800
                                                            @elseif ($reservation->status === 'cancelled') bg-red-100 text-red-800
                                                            @elseif ($reservation->status === 'expired') bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($reservation->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if ($reservation->status === 'pending')
                                                    <form action="{{ route('admin.reservations.confirm', $reservation) }}"
                                                        method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-green-500 text-gray-700 rounded-md hover:bg-blue-600">
                                                            Confirm Pickup
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.reservations.cancel', $reservation) }}"
                                                        method="POST" class="inline-block ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500">No actions available</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $reservations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
