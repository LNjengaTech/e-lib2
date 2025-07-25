@php
    $tagsArray = explode(',', $book->tags);
@endphp

@extends('layouts.home')
@section('content')
    <x-home-sections class="bg-light text-dark pb-4 py-4 flex items-center justify-between gap-[5%]">
        <img src={{ asset('/images/book2.jpg') }} alt="book" title='{{ $book->title }} by {{ $book->author }}'
            class="w-[200px] h-[70%] object-fit rounded shadow shadow-dark">
        <article class="text-dark flex flex-col gap-2">
            <h2><span class="">Title: </span><span class="font-bold text-xl">{{ $book->title }}</span></h2>
            <h3><span>Author: </span><span class="font-medium text-xl">{{ $book->author }}</span></h3>
            <p>Description: <span class="font-medium">{{ $book->description }}</span></p>
            <div class="flex gap-4">
                <p>Total Copies: <span class="font-medium">{{ $book->total_copies }}</span></p>
            <p>Books Available: <span class="font-medium">{{ $book->available_copies }}</span></p>
            </div>
            
            <p>Published: <span class="font-medium">{{ $book->published_year }}</span></p>
            {{-- Tags --}}
            <div class="flex gap-3">
                 @foreach ($tagsArray as $tag)
                 <a href="/library-catalogue?tag={{ $tag }}" class="bg-dark text-light p-1 rounded shadow shadow-dark/80 hover:bg-dark/80 transition-all">{{ $tag }}</a>
            @endforeach
            </div>
           
           


            <button>Borrow</button>

        </article>

    </x-home-sections>
@endsection
