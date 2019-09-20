@extends('layouts.default')

@section('content')
<div class="index">
    @if(! boardit\User::where('delivering', 1)->count())
        <div class="index-box info flex-center bg-project">
            <div class="text-wrapper">
                <p><b>Tyvärr</b> så finns det inga som kan leverera spel till dig för tillfället, återkom gärna någon annan dag eller kolla in vårt sortiment av spel!</p>
            </div>
        </div>
    @endif

    <div class="index-box flex-center index-jumbotron">
        <div class="jumbotron-content-wrapper">
            <img src="{{ asset('img/logo.png') }}" alt="Boarditgames">
            <p class="jumbotron-slogan">Rent it. <span class="font-project">Board it.</span> Enjoy it.</p>
        </div>
    </div>

    {{-- @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif --}}

    <div class="index-box">
        <h1>Populära spel</h1>
        <div class="popular-games-wrapper">
            @foreach($products as $product)
                @include('product.default')
            @endforeach
        </div>
    </div>

    <div class="index-box flex-center bg-project-light v-split">
        <div class="text-wrapper">
            <h1>Inom 2 timmar</h1>
            <p><b>Vid utkörning endast!</b> Om din leverans inte kommer till dig inom 2 timmar efter bekräftelse så får du låna spelet <b>gratis</b> i 24 timmar! Denna garanti är satt så att vi på boardit ska kunna försäkra er om att ni blir erhållen bästa möjliga service.</p>
        </div>

        <div class="text-wrapper">
            <h1>Upp till 24 timmar</h1>
            <p><b>Vid upphämtning endast!</b> Efter det att du fått dina spel levererade till din dörr, har du upp till 24 timmar på dig att spela så mycket det bara går, sedan kommer ett bud att hämta upp spelen igen vid samma adress som avlämningen skedde på.</p>
        </div>
    </div>
</div>
@stop
