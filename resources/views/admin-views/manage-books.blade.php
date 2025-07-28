<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">This page allows Librarians to add, edit, and delete books in the library catalog.
                    </p>
                    <!-- Main Alpine.js data scope for modals -->
                    <div x-data="{
                        showAddBookModal: false,
                        showEditBookModal: false,
                        showDeleteBookModal: false,
                        currentBook: null, // To store the book being edited or deleted
                        editForm: { // Data for the edit form
                            id: '',
                            title: '',
                            author: '',
                            isbn: '',
                            category: '',
                            available_copies: '',
                            cover_image_url: ''
                        },
                        openEditModal(book) {
                            this.currentBook = book;
                            this.editForm.id = book.id;
                            this.editForm.title = book.title;
                            this.editForm.author = book.author;
                            this.editForm.isbn = book.isbn;
                            this.editForm.category = book.category;
                            this.editForm.available_copies = book.available_copies;
                            this.editForm.cover_image_url = book.cover_image_url;
                            this.showEditBookModal = true;
                        },
                        openDeleteModal(book) {
                            this.currentBook = book;
                            this.showDeleteBookModal = true;
                        }
                    }">
                        <button @click="showAddBookModal = true"
                            class="mb-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add New
                            Book</button>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Author</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ISBN</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Available Copies</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{-- Loop through the books passed from the controller --}}
                                    @forelse ($books as $book)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->author }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->isbn }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->category }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $book->available_copies }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button @click="openEditModal({{ $book }})"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                                                <button @click="openDeleteModal({{ $book }})"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                                No books found. Please add some!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Add New Book Modal -->
                        <div x-show="showAddBookModal" class="fixed inset-0 z-50 overflow-y-auto"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                            <div
                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div x-show="showAddBookModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    aria-hidden="true">
                                </div>

                                <!-- This element is to trick the browser into centering the modal contents. -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                    aria-hidden="true">&#8203;</span>

                                <!-- Modal panel -->
                                <div x-show="showAddBookModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                    id="modal-title">
                                                    Add New Book
                                                </h3>
                                                <div class="mt-2">
                                                    <form method="POST" action="{{ route('admin.books.store') }}">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="title"
                                                                class="block text-sm font-medium text-gray-700">Title</label>
                                                            <input type="text" id="title" name="title"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="author"
                                                                class="block text-sm font-medium text-gray-700">Author</label>
                                                            <input type="text" id="author" name="author"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="isbn"
                                                                class="block text-sm font-medium text-gray-700">ISBN</label>
                                                            <input type="text" id="isbn" name="isbn"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="category"
                                                                class="block text-sm font-medium text-gray-700">Category</label>
                                                            <input type="text" id="category" name="category"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                placeholder="e.g., Science, History, Fiction" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="available_copies"
                                                                class="block text-sm font-medium text-gray-700">Available
                                                                Copies</label>
                                                            <input type="number" id="available_copies"
                                                                name="available_copies" value="1" min="0"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="cover_image_url"
                                                                class="block text-sm font-medium text-gray-700">Cover
                                                                Image
                                                                URL (Optional)</label>
                                                            <input type="url" id="cover_image_url"
                                                                name="cover_image_url"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        </div>
                                                        <div
                                                            class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                            <button type="submit"
                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Add Book
                                                            </button>
                                                            <button @click="showAddBookModal = false" type="button"
                                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Book Modal -->
                        <div x-show="showEditBookModal" class="fixed inset-0 z-50 overflow-y-auto"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
                            <div
                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div x-show="showEditBookModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    aria-hidden="true">
                                </div>

                                <!-- Modal panel -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                    aria-hidden="true">&#8203;</span>
                                <div x-show="showEditBookModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                    id="modal-title">
                                                    Edit Book
                                                </h3>
                                                <div class="mt-2">
                                                    {{-- Use x-bind:action to dynamically set the form action using JS
                                                    string interpolation --}}
                                                    <form
                                                        x-bind:action="editForm.id ? `/admin/books/${editForm.id}` : '#'"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT') {{-- Use PUT method for updates --}}
                                                        <div class="mb-4">
                                                            <label for="edit_title"
                                                                class="block text-sm font-medium text-gray-700">Title</label>
                                                            <input type="text" id="edit_title" name="title"
                                                                x-model="editForm.title"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="edit_author"
                                                                class="block text-sm font-medium text-gray-700">Author</label>
                                                            <input type="text" id="edit_author" name="author"
                                                                x-model="editForm.author"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="edit_isbn"
                                                                class="block text-sm font-medium text-gray-700">ISBN</label>
                                                            <input type="text" id="edit_isbn" name="isbn"
                                                                x-model="editForm.isbn"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="edit_category"
                                                                class="block text-sm font-medium text-gray-700">Category</label>
                                                            <input type="text" id="edit_category" name="category"
                                                                x-model="editForm.category"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="edit_available_copies"
                                                                class="block text-sm font-medium text-gray-700">Available
                                                                Copies</label>
                                                            <input type="number" id="edit_available_copies"
                                                                name="available_copies"
                                                                x-model="editForm.available_copies" min="0"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="edit_cover_image_url"
                                                                class="block text-sm font-medium text-gray-700">Cover
                                                                Image
                                                                URL (Optional)</label>
                                                            <input type="url" id="edit_cover_image_url"
                                                                name="cover_image_url"
                                                                x-model="editForm.cover_image_url"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        </div>
                                                        <div
                                                            class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                            <button type="submit"
                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Update Book
                                                            </button>
                                                            <button @click="showEditBookModal = false" type="button"
                                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div x-show="showDeleteBookModal" class="fixed inset-0 z-50 overflow-y-auto"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
                            <div
                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div x-show="showDeleteBookModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                    aria-hidden="true">
                                </div>

                                <!-- Modal panel -->
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                    aria-hidden="true">&#8203;</span>
                                <div x-show="showDeleteBookModal" x-transition:enter="ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave="ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <!-- Heroicon name: outline/exclamation-triangle -->
                                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.174 3.374 1.94 3.374h14.71c1.766 0 2.806-1.874 1.94-3.374L13.94 3.376c-.866-1.5-3.034-1.5-3.899 0L2.697 16.376zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                    id="modal-title">
                                                    Delete Book
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">
                                                        Are you sure you want to delete the book "<span
                                                            x-text="currentBook ? currentBook.title : ''"
                                                            class="font-semibold"></span>"? This action cannot be
                                                        undone.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <form x-bind:action="currentBook ? `/admin/books/${currentBook.id}` : '#'"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Delete
                                            </button>
                                        </form>
                                        <button @click="showDeleteBookModal = false" type="button"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
