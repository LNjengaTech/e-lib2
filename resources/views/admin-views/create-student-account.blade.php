<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Student Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">This page is for Super Admins to create new student accounts.</p>
                    <form>
                        <div class="mb-4">
                            <label for="student_name" class="block text-sm font-medium text-gray-700">Student
                                Name</label>
                            <input type="text" id="student_name" name="student_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="mb-4">
                            <label for="student_email" class="block text-sm font-medium text-gray-700">Student
                                Email</label>
                            <input type="email" id="student_email" name="student_email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="mb-4">
                            <label for="student_password"
                                class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="student_password" name="student_password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="mb-4">
                            <label for="student_password_confirmation"
                                class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" id="student_password_confirmation"
                                name="student_password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="mb-4">
                            <label for="fee_balance" class="block text-sm font-medium text-gray-700">Fee Balance (e.g.,
                                0.00)</label>
                            <input type="number" step="0.01" id="fee_balance" name="fee_balance" value="0.00"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Create Student
                            Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
