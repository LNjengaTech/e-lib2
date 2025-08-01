<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #e2e8f0;
            /* bg-gray-200 */
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #94a3b8;
            /* bg-gray-400 */
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
            /* bg-gray-500 */
        }

        /* Toast Notification Styling */
        .toast-enter-active,
        .toast-leave-active {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .toast-enter-from,
        .toast-leave-to {
            opacity: 0;
            transform: translateY(-20px);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <!-- Main wrapper for the entire layout, controlled by Alpine.js for sidebar toggle -->
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        <!-- sidebarOpen is now false by default for all screens -->
        <!-- Sidebar -->
        <!-- The sidebar is now always controlled by sidebarOpen, overlaying content when open. -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col min-h-screen shadow-lg sidebar overflow-y-auto
                      fixed inset-y-0 left-0 z-40 transform transition-transform duration-300 ease-in-out"
            :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            <div class="p-6 border-b border-gray-700 flex items-center justify-between">
                <a href="/"><img src="/favicon.ico" alt="home" title="home"
                        class="w-[40px] h-[40px] object-cover rounded"></a>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <span class="text-xl font-semibold">Library Admin</span>
                </a>
                <!-- Close button for sidebar - now always visible when sidebar is open -->
                <button @click="sidebarOpen = false"
                    class="flex items-center justify-center text-gray-300 hover:text-white rounded-md focus:outline-none hover:bg-gray-700 transition">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            <nav class="flex-grow p-4 space-y-2">
                <x-sidebar-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Dashboard') }}
                </x-sidebar-nav-link>
                <x-sidebar-nav-link :href="route('admin.books')" :active="request()->routeIs('admin.books')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                    </svg>
                    {{ __('Books') }}
                </x-sidebar-nav-link>
                <x-sidebar-nav-link :href="route('admin.loans')" :active="request()->routeIs('admin.loans')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    {{ __('Loans') }}
                </x-sidebar-nav-link>
                <x-sidebar-nav-link :href="route('admin.reservations')"
                    :active="request()->routeIs('admin.reservations')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17l-3 3m0 0l-3-3m3 3V5m0 12a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                    {{ __('Reservations') }}
                </x-sidebar-nav-link>
                <x-sidebar-nav-link :href="route('admin.fines')" :active="request()->routeIs('admin.fines')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ __('Fines') }}
                </x-sidebar-nav-link>
                <x-sidebar-nav-link :href="route('admin.members')" :active="request()->routeIs('admin.members')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M9 20v-2a3 3 0 00-3-3H4a3 3 0 00-3 3v2.5M17 9a2 2 0 11-4 0 2 2 0 014 0zM7 13a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ __('Members') }}
                </x-sidebar-nav-link>

                <div class="border-t border-gray-700 my-4 pt-4">
                    <p class="text-xs uppercase text-gray-400 mb-2 px-3">Super Admin</p>
                    <x-sidebar-nav-link :href="route('admin.add-librarian')"
                        :active="request()->routeIs('admin.add-librarian')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14v5m-3-5h6" />
                        </svg>
                        {{ __('Add Librarian') }}
                    </x-sidebar-nav-link>
                    {{-- Removed 'Create Student Account' as per new requirement --}}
                </div>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-sidebar-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </x-sidebar-nav-link>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <!-- The main content area now shifts based on sidebarOpen state for all screen sizes -->
        <div class="flex-1 flex flex-col transition-all duration-300 ease-in-out"
            :class="{ 'ml-64': sidebarOpen, 'ml-0': !sidebarOpen }">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm py-4 px-6 flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Hamburger menu button - hidden when sidebar is open -->
                    <button x-show="!sidebarOpen" @click="sidebarOpen = true"
                        class="p-3 w-12 h-12 flex items-center justify-center text-gray-700 hover:text-gray-900 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $header ?? 'Admin Panel' }}
                    </h2>
                    <!-- Search Bar (Placeholder) -->
                    <form method="GET" class="ml-6 relative hidden sm:block">
                        <input type="text" placeholder="Search..."
                            class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            name="search">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </form>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Notifications Icon -->
                    <button class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
                    </button>

                    <!-- User Dropdown (Profile) -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                                <img class="h-8 w-8 rounded-full object-cover mr-2"
                                    src="https://placehold.co/40x40/E0E0E0/333333?text=AD"
                                    alt="{{ Auth::user()->name }}" />
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

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
    }" x-init="
        @if (session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        @if ($errors->any())
            showToast('{{ $errors->first() }}', 'error'); // Display the first error
        @endif
    "
        class="fixed inset-x-0 top-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
        <div x-show="show" x-transition:enter="toast-enter-active" x-transition:enter-start="toast-enter-from"
            x-transition:enter-end="toast-enter-to" x-transition:leave="toast-leave-active"
            x-transition:leave-start="toast-leave-from" x-transition:leave-end="toast-leave-to"
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
            :class="{
                ' bg-green-100 border border-green-400 text-green-700': type === 'success',
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
