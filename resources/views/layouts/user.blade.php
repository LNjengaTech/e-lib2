<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Bitcount:wght@100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- include the compiled css -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ config('app.name') . ' My Dashboard' }}</title>
</head>

<body class="text-black w-full mx-auto font-inter bg-slate-200">
    <section class="flex">
        @include('partials.user-sidebar')

        <section class="flex-1 flex flex-col ml-64 max-890px:ml-0">
            @include('partials.user-nav')
            <section class=" px-10 max-890px:px-1 mt-10 ">
                @yield('content')
            </section>
        </section>
    </section>

    <!-- Toast Notification Container -->
    <div x-data="{
        show: false,
        message: '',
        type: '', // 'success' or 'error'
        timeout: null,
        showToast(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.show = true;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.show = false;
            }, 5000); // Hide after 5 seconds
        }
    }" x-init="@if(session('success'))
    showToast('{{ session('success') }}', 'success');
    @endif
    @if($errors->any())
    showToast('{{ $errors->first() }}', 'error'); // Display the first error
    @endif"
        class="fixed inset-x-0 top-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
        <div x-show="show" x-transition:enter="toast-enter-active" x-transition:enter-start="toast-enter-from"
            x-transition:enter-end="toast-enter-to" x-transition:leave="toast-leave-active"
            x-transition:leave-start="toast-leave-from" x-transition:leave-end="toast-leave-to"
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
            :class="{
                'border-l-4 border-green-500': type === 'success',
                'border-l-4 border-red-500': type === 'error'
            }">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <template x-if="type === 'success'">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="type === 'error'">
                            <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.174 3.374 1.94 3.374h14.71c1.766 0 2.806-1.874 1.94-3.374L13.94 3.376c-.866-1.5-3.034-1.5-3.899 0L2.697 16.376zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </template>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900" x-text="message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false"
                            class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path
                                    d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
