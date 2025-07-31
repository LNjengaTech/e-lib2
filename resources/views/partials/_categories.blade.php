<section
    class="bg-dark text-light mt-10 rounded py-4 px-2 max-1500px:px-3 shadow shadow-slate-800 max-600px:rounded-none relative">
    <span class="flex items-center gap-4 600px:hidden">
        <i id="open-cats" class="fa-solid fa-list  cursor-pointer text-xl hover:text-light/60 transition-all"></i> <span
            class="text-light/60">All Categories</span>
    </span>

    <header id="all-cats-header"
        class="flex gap-[2%] items-center max-600px:grid max-600px:grid-cols-3 max-390px:grid-cols-2 max-200px:grid-cols-1 max-600px:bg-light max-600px:w-fit max-600px:hidden max-600px:absolute max-600px:rounded max-600px:px-2 max-600px:shadow max-600px-shadow-dark/60 max-600px:min-h-[300px] max-600px:overflow-y-auto">
        <section id="cats" class="flex flex-col relative rounded max-600px:hidden max-600px:min-h-[1000px] ">
            <div id="all-bar"
                class="cursor-pointer bg-light text-dark rounded p-1 px-2 hover:bg-light/30 transition-all hover:text-light shadow shadow-light duration-300 group w-fit">
                <span>Categories</span>
                <i class="fa-solid fa-chevron-down group-hover:hidden inline-block"></i>
                <i class="fa-solid fa-chevron-down hidden group-hover:inline-block"></i>
            </div>
            <article id="cat-dropdown"
                class="absolute mt-[36px] grid grid-cols-3 w-full min-w-[500px] z-10 bg-light p-3 rounded shadow shadow-dark/4 ">
                @foreach($categories as $category)
                    <a class="cat-all bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
                    href="/library-catalogue?category=new">{{ $category }}</a>
                @endforeach
                
            </article>
        </section>
        <a id="cat-0"
            class="bg-light text-dark rounded p-1 px-2 hover:bg-light/30 transition-all hover:text-light max-600px:hover:text-dark/80 max-600px:hover:underline shadow shadow-light duration-300 :bg-light/30 max-600px:hover:text-light max-600px:hover:bg-transparent"
            href="/library-catalogue">All</a>
        <a id="cat-1"
            class="bg-light text-dark rounded p-1 px-2 hover:bg-light/30 transition-all hover:text-light max-600px:hover:text-dark/80 max-600px:hover:underline shadow shadow-light duration-300 :bg-light/30 max-600px:hover:text-light max-600px:hover:bg-transparent"
            href="/library-catalogue?category=new">New</a>
        <a id="cat-2"
            class="bg-light text-dark rounded p-1 px-2 hover:bg-light/30 transition-all hover:text-light max-600px:hover:text-dark/80 max-600px:hover:underline shadow shadow-light duration-300 :bg-light/30 max-600px:hover:text-light max-600px:hover:bg-transparent"
            href="/library-catalogue?category=engineering">Engineering</a>
        <a id="cat-3"
            class="bg-light text-dark rounded p-1 px-2 hover:bg-light/30 transition-all hover:text-light max-600px:hover:text-dark/80 max-600px:hover:underline shadow shadow-light duration-300 :bg-light/30 max-600px:hover:text-light max-600px:hover:bg-transparent"
            href="/library-catalogue?category=psychology">Psychology</a>
        <a id="cat-4"
            class="bg-light text-dark rounded p-1 px-2 hover:bg-light/30 transition-all hover:text-light shadow shadow-light duration-300 :bg-light/30 max-600px:hover:text-dark/80 max-600px:hover:underline max-600px:hover:bg-transparent"
            href="/library-catalogue?category=maths">maths</a>

        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=new">New</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=engineering">Engineering</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=psychology">Psychology</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=maths">maths</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=science">Science</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=science">Health</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=science">Physics</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=science">Chemistry</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=science">Biology</a>
        <a class="cat-all 600px:hidden bg-light text-dark rounded p-1 px-2 transition-all hover:bg-dark/70 hover:text-light duration-200"
            href="/library-catalogue?category=science">Fiction</a>

    </header>

    <script>
        const allBar = document.getElementById('all-bar');
        const catDropdown = document.getElementById('cat-dropdown');
        const allCategories = document.getElementsByClassName('cat-all');
        const openCats = document.getElementById('open-cats');
        const allCats = document.getElementById('all-cats-header')

        openCats.addEventListener('click', () => {
            allCats.classList.toggle('max-600px:hidden');
        })

        allCategories.onClick = function() {
            catDropdown.classList.toggle('hidden')
        }
        //initially hidden
        catDropdown.classList.add('hidden');

        //open dropdown
        allBar.addEventListener('click', () => {
            catDropdown.classList.toggle("hidden")
        })
    </script>
</section>
