<x-home-sections>
    <h2 class="font-bold text-2xl max-1000px:text-xl mb-20 max-890px:text-center font-mono">Welcome to the Library Section</h2>

    <section class="mt-5 grid place-items-center grid-cols-4 max-890px:grid-cols-2 max-890px:gap-5 max-390px:grid-cols-1 max-390px:px-5">
        <a href="/library-catalogue"
            class="flex flex-col items-center 1500px:w-[320px] max-1500px:w-[280px] max-1360px:w-[260px] max-1230px:w-[240px] max-1150px:w-[200px] max-890px:w-[100%] flex-wrap h-[200px] max-890px:h-[180px] bg-light/20 justify-center rounded shadow-sm shadow-light/50 cursor-pointer gap-5 group ">
            <i class="fa-solid fa-book-open-reader text-5xl max-1500px:text-3xl group-hover:scale-75 duration-300"></i>
            <span class="text-light/80 text-lg max-1500px:text-base group-hover:text-light transition-all duration-300">Borrow Books</span>
        </a>
        <a href="/user-dashboard"
            class="flex flex-col items-center 1500px:w-[320px] max-1500px:w-[280px] max-1360px:w-[260px] max-1230px:w-[240px] max-1150px:w-[200px] max-890px:w-[100%] flex-wrap h-[200px] max-890px:h-[180px] bg-light/20 justify-center rounded shadow-sm shadow-light/50 cursor-pointer gap-5 group">
            <i class="fa-regular fa-handshake text-5xl max-1500px:text-3xl group-hover:scale-75 duration-300"></i>
            <span class="text-light/80 text-lg max-1500px:text-base group-hover:text-light transition-all duration-300">Return Books</span>
        </a>
        <a href="/library-catalogue"
            class="flex flex-col items-center 1500px:w-[320px] max-1500px:w-[280px] max-1360px:w-[260px] max-1230px:w-[240px] max-1150px:w-[200px] max-890px:w-[100%] flex-wrap h-[200px] max-890px:h-[180px] bg-light/20 justify-center rounded shadow-sm shadow-light/50 cursor-pointer gap-5 group">
            <i class="fa-solid fa-magnifying-glass text-5xl max-1500px:text-3xl group-hover:scale-75 duration-300"></i>
            <span class="text-light/80 text-lg max-1500px:text-base group-hover:text-light transition-all duration-300">Search for Books</span>
        </a>
        <a href="/library-catalogue?tags=new"
            class="flex flex-col items-center 1500px:w-[320px] max-1500px:w-[280px] max-1360px:w-[260px] max-1230px:w-[240px] max-1150px:w-[200px] max-890px:w-[100%] flex-wrap h-[200px] max-890px:h-[180px] bg-light/20 justify-center rounded shadow-sm shadow-light/50 cursor-pointer gap-5 group">
            <i class="fa-solid fa-bell text-5xl max-1500px:text-3xl group-hover:scale-75 transition-all duration-300"></i>
            <span class="text-light/80 text-lg max-1500px:text-base group-hover:text-light transition-all duration-300">New Arrivals</span>
        </a>
    </section>
</x-home-sections>
