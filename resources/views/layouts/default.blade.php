<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Boardit</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>

        <!-- Style -->
        <link href="{!! asset('css/app.css') !!}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        {{-- jQuery --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        {{-- Checkout --}}
        <script type="text/javascript" src="https://checkout.stripe.com/checkout.js"></script>

        {{-- Re-captcha --}}
        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>

        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
    </head>
    <body>
        @include('navbar')

        <div class="content">
            @yield('content')
        </div>

        @include('footer')
    </body>
</html>
