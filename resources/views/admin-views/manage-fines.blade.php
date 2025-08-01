<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Fines') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">View and manage fines issued to students for overdue books or other violations.</p>

                    {{-- Session Messages --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Warning!</strong>
                            <span class="block sm:inline">{{ session('warning') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        @if ($fines->isEmpty())
                            <p class="text-gray-600">No fines to display at the moment.</p>
                        @else
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Book Title (if applicable)</th> {{-- Updated column header --}}
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Reason</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Issued Date</th> {{-- NEW: Added Issued Date column --}}
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Paid Date</th> {{-- NEW: Added Paid Date column --}}
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($fines as $fine)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $fine->user->name ?? 'N/A' }}
                                                <br>
                                                <span class="text-xs text-gray-500">Reg: {{ $fine->user->reg_number ?? 'N/A' }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $fine->loan->book->title ?? 'N/A' }} {{-- Access book title via loan --}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                ${{ number_format($fine->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $fine->reason }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $fine->issued_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $fine->paid_at ? $fine->paid_at->format('Y-m-d H:i') : 'Outstanding' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if ($fine->status === 'outstanding') bg-red-100 text-red-800
                                                    @elseif ($fine->status === 'paid') bg-green-100 text-green-800
                                                    @elseif ($fine->status === 'waived') bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($fine->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if ($fine->status === 'outstanding') {{-- Only show buttons if fine is outstanding --}}
                                                    <form action="{{ route('admin.fines.pay', $fine) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                                                            Mark Paid
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.fines.waive', $fine) }}" method="POST" class="inline-block ml-2">
                                                        @csrf
                                                        @method('PUT') {{-- Waiving is also an update --}}
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                                            Waive
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
                                {{ $fines->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
