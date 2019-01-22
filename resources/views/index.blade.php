@extends('layouts.default')

@section('content')
<div class="index">
    <div class="index-box flex-center index-jumbotron">
        <div class="jumbotron-content-wrapper">
            <img src="{{ asset('img/logo.png') }}" alt="Boarditgames">
            <p class="jumbotron-slogan">Rent it. Board it. Enjoy it.</p>
        </div>
    </div>

    @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif

    <div class="index-box">
        <h1>Populära spel</h1>
        <div class="popular-games-wrapper">
            @foreach($products as $product)
                @include('product.default')
            @endforeach
        </div>
    </div>

    <div class="index-box flex-center bg-gray v-split">
        <div class="text-wrapper">
            <h1>Inom 1 timme</h1>
            <p>Om din leverans inte kommer till dig inom 1 timme efter bekräftelse så får du låna spelet <b>gratis</b>! Denna garanti är satt pågrund av att kunna försäkra er om att ni blir erhållen bästa möjliga service.</p>
        </div>

        <div class="text-wrapper">
            <h1>Upp till 24 timmar</h1>
            <p>Efter det att du fått dina spel levererade till din dörr, har du upp till 24 timmar på dig att spela så mycket det bara går, sedan kommer ett bud att hämta upp spelen igen vid samma adress som avlämningen skedde på.</p>
        </div>
    </div>
</div>
@stop
