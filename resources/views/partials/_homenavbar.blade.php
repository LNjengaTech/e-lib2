<header
    class=" w-full mx-auto bg-dark p-4 px-5 rounded mt-2  max-630px:mt-0 max-630px:rounded-none max-630px:p-5 font-mono shadow shadow-slate-500">
    <nav class="text-light flex justify-between items-center">
        <a href='/' class ="text-2xl max-600px:text-xl font-bitcount">
            {{-- <img src="{{ asset('images/logo.png') }}" class="w-[120px] h-[50px] border" /> --}}
            e-library
        </a>

        <ul id="sidebar"
            class="flex items-center font-bold max-630px:flex-col max-630px:items-start max-630px:rounded max-630px:shadow-md  max-630px:border-y max-630px:fixed max-630px:top-[15px] max-630px:right-1 max-630px:bg-dark max-630px:gap-5 max-630px:h-[210px] max-630px:p-2 max-630px:pt-14 max-200px:right-0 max-200px:top-[70px] max-630px:hidden z-[100]">
            <li
                class="mx-6 max-1000px:mx-2 max-630px:mx-1 cursor-pointer hover:bg-light hover:text-dark transition-all rounded duration-300 ">
                <a href="/library-catalogue" class="p-1">Library Catalogue</a>
            </li>
            <hr class="bg-light/80 w-[1px] h-5 max-630px:hidden">
            </hr>
            <li
                class="mx-6 max-1000px:mx-2 max-630px:mx-1  cursor-pointer hover:bg-light hover:text-dark transition-all  rounded duration-300">
                <a href="/exam-bank" class="p-1">Exam Bank</a>
            </li>
            <a href="{{ route('login') }}"
                class="bg-light text-dark p-2 rounded px-3 font-bold hover:bg-light/90 transition-all 630px:hidden mt-2">
                <span>Login</span>
                <i class="fa-solid fa-book-open">
                </i></a>
        </ul>
        <section class="max-630px:hidden">
            <a href="{{ route('login') }}" class="bg-light text-dark p-2 rounded px-3 font-bold hover:bg-light/90 transition-all ">
                <span>Login</span>
                <i class="fa-solid fa-book-open">
                </i></a>
        </section>
        <section class="630px:hidden z-[100]">
            <i id="openSidebar" class="fa-solid fa-bars-staggered text-xl cursor-pointer"></i>
            <i id="closeSidebar" class="fa-solid fa-xmark text-2xl cursor-pointer hidden"></i>
        </section>
    </nav>
    <script src="js/main.js"></script>
    </nav>
</header>
