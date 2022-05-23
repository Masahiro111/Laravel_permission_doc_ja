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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.1.0/github-markdown.min.css">

        <style>
            .markdown-body {
                box-sizing: border-box;
                min-width: 200px;
                max-width: 980px;
                margin: 0 auto;
                padding: 45px;
            }

            @media (max-width: 767px) {
                .markdown-body {
                    padding: 15px;
                }
            }
        </style>

        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/alpinejs" defer></script>
    </head>

    <body class="text-gray-900 font-sans antialiased">

        @include('_partials.nav')

        <div class="markdown-body">

            <h2 class="mb-2">{{ $page->title }}</h2>
            <h4 class="mb-2">Author : {{ $page->author }}</h4>

            @yield('body')

        </div>

    </body>

</html>