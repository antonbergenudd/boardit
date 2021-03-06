<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148437942-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-148437942-1');
        </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Hyr brädspel levererat till dörren.">
        <meta name="keywords" content="Hyr brädspel, brädspel, hemleverans, studentpriser">

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

            {{-- @if(isset($cart) && $cart->first()) --}}
            {{-- @endif --}}
        </div>

        @include('footer')
    </body>

</html>
