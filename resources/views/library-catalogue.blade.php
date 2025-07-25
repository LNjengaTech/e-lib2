
@extends('layouts.home')
@section('content')

<section class="mt-10">
    @include('partials._librarySearch')
    @include('partials._categories')
    
    {{-- Show all books --}}
   
    <x-catalogue :books="$books"></x-catalogue>

    {{-- Pages --}}
    
</section>
@endsection