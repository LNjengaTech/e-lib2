@extends('layouts.user')
@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p class="mb-4">Here are the books you have currently borrowed or have returned.</p>

                {{-- Session Messages --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
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
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Warning!</strong>
                        <span class="block sm:inline">{{ session('warning') }}</span>
                    </div>
                @endif

                @if (session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Heads Up!</strong>
                        <span class="block sm:inline">{{ session('info') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    {{-- Changed $borrowed to $loans as per UserController --}}
                    @if ($loans->isEmpty())
                        <p class="text-gray-600">You have no borrowed books to display at the moment.</p>
                    @else
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
                                        Borrowed At</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Returned Date</th> {{-- NEW: Added Returned Date column --}}
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Changed $borrowed as $book to $loans as $loan --}}
                                @foreach ($loans as $loan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $loan->book->title ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $loan->book->author ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $loan->borrowed_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $loan->due_date->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $loan->returned_at ? $loan->returned_at->format('Y-m-d H:i') : 'Not Returned' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if ($loan->status === 'borrowed') bg-blue-100 text-blue-800
                                                            @elseif ($loan->status === 'returned') bg-green-100 text-green-800
                                                            @elseif ($loan->status === 'overdue') bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $loans->links() }} {{-- Ensured pagination links are present --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
