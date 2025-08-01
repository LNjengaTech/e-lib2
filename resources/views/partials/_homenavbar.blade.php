<header
    class=" w-full mx-auto bg-dark p-4 px-5 rounded mt-2  max-890px:mt-0 max-890px:rounded-none max-890px:p-5 font-mono shadow shadow-slate-500">
    <nav class="text-light flex justify-between items-center">
        <a href='/' class ="text-2xl max-600px:text-xl font-bitcount">
            {{-- <img src="{{ asset('images/logo.png') }}" class="w-[120px] h-[50px] border" /> --}}
            e-library
        </a>

        <ul id="sidebar"
            class="flex items-center font-bold max-890px:flex-col max-890px:items-start max-890px:rounded max-890px:shadow-md  max-890px:border-y max-890px:fixed max-890px:top-[15px] max-890px:right-1 max-890px:bg-dark max-890px:gap-5 max-890px:h-[250px] max-890px:p-2 max-890px:pt-14 max-200px:right-0 max-200px:top-[70px] max-890px:hidden z-[100]">
            <li
                class="mx-6 max-1000px:mx-2 max-890px:mx-1 cursor-pointer hover:bg-light hover:text-dark transition-all rounded duration-300 ">
                <a href="/library-catalogue" class="p-1">Library Catalogue</a>
            </li>
            <hr class="bg-light/80 w-[1px] h-5 max-890px:hidden">
            </hr>
            <li
                class="mx-6 max-1000px:mx-2 max-890px:mx-1  cursor-pointer hover:bg-light hover:text-dark transition-all  rounded duration-300">
                <a href="/exam-bank" class="p-1">Exam Bank</a>
            </li>

            @auth
                <hr class="bg-light/80 w-[1px] h-5 max-890px:hidden">
                </hr>
                <li
                    class="mx-6 max-1000px:mx-2 max-890px:mx-1  cursor-pointer hover:bg-light hover:text-dark transition-all  rounded duration-300">
                    <a href={{ Auth()->user()->utype === 'ADM' ? '/admin/dashboard' : '/user-dashboard' }} class="p-1">My
                        Dashboard</a>
                    {{--  $user->utype === 'ADM' ? '/admin/dashboard' : '/user-dashboard' --}}
                </li>
            @endauth
            <a href="{{ route('login') }}"
                class="bg-light text-dark p-2 rounded px-3 font-bold hover:bg-light/90 transition-all 890px:hidden mt-2">
                <span>Login</span>
                <i class="fa-solid fa-book-open">
                </i></a>
        </ul>
        @auth
            <form action="{{ route('logout') }}" method="POST" class="max-890px:hidden">
                @csrf
                <button type="submit"
                    class="bg-red-500 text-light p-2 rounded px-3 font-bold hover:bg-light/90 transition-all ">
                    <span>Logout</span>
                    <i class="fa-solid fa-door-open">
                    </i></button>
            </form>
        @else
            <section class="max-890px:hidden">
                <a href="{{ route('login') }}"
                    class="bg-light text-dark p-2 rounded px-3 font-bold hover:bg-light/90 transition-all ">
                    <span>Login</span>
                    <i class="fa-solid fa-book-open">
                    </i></a>
            </section>
        @endauth

        <section class="890px:hidden z-[100]">
            <i id="openSidebar" class="fa-solid fa-bars-staggered text-xl cursor-pointer"></i>
            <i id="closeSidebar" class="fa-solid fa-xmark text-2xl cursor-pointer hidden"></i>
        </section>
    </nav>
    {{-- <script src="js/main.js"></script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const openBtn = document.getElementById("openSidebar");
            const closeBtn = document.getElementById("closeSidebar");
            if (openBtn && closeBtn && sidebar) {
                openBtn.addEventListener("click", function() {
                    sidebar.classList.remove("max-890px:hidden");
                    openBtn.classList.add("hidden");
                    closeBtn.classList.remove("hidden");
                });
                closeBtn.addEventListener("click", function() {
                    sidebar.classList.add("max-890px:hidden");
                    openBtn.classList.remove("hidden");
                    closeBtn.classList.add("hidden");
                });
            }
        });
    </script>
    </nav>
</header>
