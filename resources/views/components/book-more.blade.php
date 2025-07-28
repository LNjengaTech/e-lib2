@props(['book'])
@php
    $title = substr($book->title, 0, 20)
@endphp

<section class="w-[180px] h-[340px] p-1">
    <a href="/book/{{ $book->id }}">
        <img src={{ asset('/images/book-placeholder.jpg') }} alt="book"
            title='{{ $book->title }} by {{ $book->author }}'
            class="w-[90%] mx-auto h-[70%] object-fit rounded shadow shadow-dark">
        <p class="text-dark/80 text-center my-2">{{ $title }}</p>
    </a>   
    <a href="/book/{{ $book->id }}"
            class="bg-dark w-full block text-center p-2 rounded hover:text-light/90 hover:bg-dark/90 transition-all">
            View
        </a>

    
    </a>
</section>
