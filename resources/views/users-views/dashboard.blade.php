{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <h1 class="text-white">STUDENT DASHBOARD</h1>
    </div>
</x-app-layout> --}}

@extends('layouts.user')
@section('content')
<article class="mb-20 font-semibold text-center">
    <h2 class="text-3xl font-mono max-1000px:text-xl">Welcome to your <span class="text-blue font-bitcount">e-library</span> Dashboard</h2>
</article>
    <section class="flex justify-between items-center max-1000px:flex-col max-1000px:gap-20">
        {{-- Links --}}
        <section class="flex flex-wrap gap-5 max-890px:justify-center place-self-start max-1000px:place-self-center">

            <article class="">
                <a href="{{ route('borrowed-books') }}"
                    class="bg-light text-gray-800 flex justify-between p-6 items-center gap-5 rounded shadow shadow-gray-800 border-l-4 border-gray-800 py-4 hover:scale-95 transition-all duration-300 group w-[350px] max-1050px:w-[280px] max-920px:w-[250px] max-890px:w-[350px] max-630px:w-[250px] max-730px:w-[300px]">
                    <i class="fa-solid fa-book-open-reader text-5xl group-hover:scale-105 transition-all duration-300"></i>
                    <span class="text-xl font-semibold transition-all duration-300 group-hover:text-gray-800">My Borrowed
                        Book List</span>

                </a>
            </article>
            <article>
                <a href="{{ route('returned-books') }}"
                    class="bg-light text-gray-800 flex justify-between p-6 items-center gap-5 rounded shadow shadow-gray-800 border-l-4 border-yellow py-4 hover:scale-95 transition-all duration-300 group w-[350px] max-1050px:w-[280px] max-920px:w-[250px] max-890px:w-[350px] max-630px:w-[250px] max-730px:w-[300px]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-12 text-yellow">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m7.49 12-3.75 3.75m0 0 3.75 3.75m-3.75-3.75h16.5V4.499" />
                    </svg>
                    <span class="text-xl font-semibold transition-all duration-300 group-hover:text-gray-800">My Returned
                        Book List</span>
                </a>
            </article>

            <article>
                <a href="/reserved-books"
                    class="bg-light text-gray-800 flex justify-between p-6 items-center gap-5 rounded shadow shadow-gray-800 border-l-4 border-blue py-4 hover:scale-95 transition-all duration-300 group w-[350px] max-1050px:w-[280px] max-920px:w-[250px] max-890px:w-[350px] max-630px:w-[250px] max-730px:w-[300px]">
                    <i class="fa-solid fa-receipt text-5xl text-blue"></i>
                    <span class="text-xl font-semibold transition-all duration-300 group-hover:text-gray-800">My Reserved
                        Books</span>
                </a>
            </article>

            <article>
                <a href="/library-catalogue"
                    class="bg-light text-gray-800 flex justify-between p-6 items-center gap-5 rounded shadow shadow-gray-800 border-l-4 border-gray-800 py-4 hover:scale-95 transition-all duration-300 group w-[350px] max-1050px:w-[280px] max-920px:w-[250px] max-890px:w-[350px] max-630px:w-[250px] max-730px:w-[300px]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-12">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5" />
                    </svg>
                    <span class="text-xl font-semibold transition-all duration-300 group-hover:text-gray-800">Browse
                        Available Books</span>
                </a>
            </article>

        </section>
        {{-- chart canvas --}}
        <div class="flex justify-center w-[40%]  place-self-end max-1000px:place-self-center max-1300px:w-[80%] max-1000px:w-[60%] max-600px:w-[100%]">
            <canvas id="bookChart" width="140" height="140" class="w-[140px] h-[140px]"></canvas>

        </div>
    </section>
    {{-- chart.js pie chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bookChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: [
                    'Borrowed Books',
                    'Returned Books'
                ],
                datasets: [{
                    label: 'Books Borrowed and returned',
                    data: [30, 10],
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }],

            }
        });
    </script>
@endsection
