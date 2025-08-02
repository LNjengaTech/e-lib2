@extends('layouts.user')
@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p class="mb-4">This page shows the penalties you have accrued due to late returning of books</p>
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
                                    Due Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Penalty</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($fines as $fine)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->loan->catalogue->author }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->loan->catalogue->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->issued_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $fine->status }}</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">You have no active fines.</td>
                                </tr>
                            @endforelse
                            {{-- <td class="px-6 py-4 whitespace-nowrap">The Great Novel</td>
                                <td class="px-6 py-4 whitespace-nowrap">Jane Doe</td>

                                <td class="px-6 py-4 whitespace-nowrap">2025-08-15</td>
                                <td class="px-6 py-4 whitespace-nowrap">Ksh. 100</td>
                                <td class="px-6 py-4 whitespace-nowrap">True</td> --}}

                            <!-- More rows will be added dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
