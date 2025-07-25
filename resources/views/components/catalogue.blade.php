@props(['books'])

@php
    //get current page from query
    // $page = request()->query('page', 1);
    // $page = max($page, 1);
@endphp

<x-home-sections class=" bg-light text-dark mt-10 rounded py-8 pb-8 max-1500px:px-3">
    <div class="flex flex-wrap gap-5 gap-y-10 justify-start">
        @foreach ($books as $book)
            <x-book-more :book="$book">
                {{ $slot }}
            </x-book-more>
        @endforeach
    </div>

    <section class=" mt-10">
        {{-- <a href="/library-catalogue/?page={{ $page - 1 }}"
            class="bg-dark text-light p-[5px] rounded px-2.5 hover:bg-dark/85 transition-all"><i
                class="fa-solid fa-arrow-left"></i>
            <span>Prev</span></a>
        <a href="/library-catalogue/?page={{ $page + 1 }}"
            class="bg-dark text-light p-[5px] rounded px-2.5 hover:bg-dark/85 transition-all">
            <span>Next</span><i class="fa-solid fa-arrow-right"></i></a> --}}
            {{ $books->links() }}
    </section>
</x-home-sections>
