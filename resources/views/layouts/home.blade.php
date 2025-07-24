<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Bitcount:wght@100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- include the compiled css -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ config('app.name'). ' Home' }}</title>
</head>

<body class="text-black 1000px:max-w-[90%] w-full mx-auto max-1000px:px-2 max-630px:px-0 font-inter">
    <section class="">
        @include('partials._homenavbar')
        <section class="max-w-[1800px] mx-auto scroll-auto">
            @yield('content')
        </section>
        @include('partials._homeFooter')
    </section>

</body>

</html>
