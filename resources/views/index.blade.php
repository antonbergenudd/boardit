@extends('layouts.default')
@section('content')
    <div class="flex-center" style=" background: white; width:100%; height:30rem;">
        <div class="">
            <img src="{{ asset('img/logo.png') }}" alt="" style="width:20rem;">
            <p style="font-size:20pt;">Rent it. Board it. Enjoy it.</p>
        </div>
    </div>

    @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif

    <div class="">
        <h1>Populära spel</h1>
        <div style="display:flex; flex-wrap:wrap; padding:3rem 0;">
            @foreach($products as $product)
                @include('product.default')
            @endforeach
        </div>
    </div>

    <div class="flex-center" style="background-color:rgba(0,0,0,.1);">
        <div class="" style="width:40rem; padding:5rem;">
            <h1 style="font-size:40pt; margin-bottom:0;">Inom 1 timme</h1>
            <p style="font-size:18pt;">Om din leverans inte kommer till dig inom 1 timme efter bekräftelse så får du låna spelet <b>gratis</b>! Denna garanti är satt pågrund av att kunna försäkra er om att ni blir erhållen bästa möjliga service.</p>
        </div>

        <div class="" style="width:40rem; padding:5rem;">
            <h1 style="font-size:40pt; margin-bottom:0;">Upp till 24 timmar</h1>
            <p style="font-size:18pt;">Efter det att du fått dina spel levererade till din dörr, har du upp till 24 timmar på dig att spela så mycket det bara går, sedan kommer ett bud att hämta upp spelen igen vid samma adress som avlämningen skedde på.</p>
        </div>
    </div>
@stop
