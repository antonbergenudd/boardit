<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BoardIt</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Style -->
        <link href="{!! asset('css/app.css') !!}" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

    </head>
    <body>
        @include('navbars/auth')

        <div class="content">
            @yield('content')
        </div>

        @include('footer')
    </body>
</html>
