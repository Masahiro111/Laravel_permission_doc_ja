<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        {{--
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}"> --}}
        {{-- <script defer src="{{ mix('js/main.js', 'assets/build') }}"></script> --}}

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/alpinejs" defer></script>
    </head>

    <body class="text-gray-900 font-sans antialiased">

        @include('_partials.nav')

        @yield('body')
    </body>

</html>