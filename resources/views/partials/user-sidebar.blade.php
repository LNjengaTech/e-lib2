{{-- <aside class="w-64 bg-gray-800 text-white flex flex-col min-h-screen shadow-lg sidebar overflow-y-auto fixed inset-0 max-600px:absolute max-600px:top-0 max-600px:bottom-0 max-600px:h-screen"> --}}
<div x-data="{ open: false }">
    <button class="bg-white px-2 text-xl 600px:hidden">
        <a class="fa-solid fa-bars cursor-pointer" x-on:click="open=true"></a>
    </button>
<!-- Overlay -->
    <div 
    x-show="open && window.innerWidth < 640"
    x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 z-40"
    x-on:click="open = false"
    ></div>

    <aside x-show="open || window.innerWidth >= 600" x-on:resize.window="if (window.innerWidth >= 600) open = true"
        :class="{ 'hidden': !open && window.innerWidth < 640 }"
        class="w-64 bg-gray-800 text-white flex flex-col min-h-screen shadow-lg sidebar overflow-y-auto fixed inset-y-0 max-600px:fixed max-600px:inset-y-0 left-0 z-50">

        <div class="p-6 border-b border-gray-700 flex items-center justify-between">
            <a href="{{ route('user-dashboard') }}" class="flex items-center space-x-3">

                <span class="text-xl font-semibold">My Dashboard</span>
                <a class="fa-solid fa-x cursor-pointer 600px:hidden" x-on:click="open=false "></a>

            </a>
        </div>

        <nav class="flex-grow p-4">
            <x-sidebar-link :href="route('user-dashboard')" :active="request()->routeIs('user-dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('Dashboard') }}
            </x-sidebar-link>
            <x-sidebar-link :href="route('user-books')" :active="request()->routeIs('user-books')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253" />
                </svg>
                {{ __('Books') }}
            </x-sidebar-link>
            <x-sidebar-link :href="route('user-books')" :active="request()->routeIs('user-books')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-500" fill="none"
                    viewBox="0 0 24 24" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>

                {{ __('Fines') }}
            </x-sidebar-link>
        </nav>

        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-sidebar-link :href="route('logout')"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Log Out') }}
                </x-sidebar-link>
            </form>
        </div>
    </aside>
</div>
