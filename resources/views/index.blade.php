@extends('layouts.default')
@section('content')
    <div class="flex-center" style=" background: white; width:100%; height:30rem;">
        {{-- <h1 class="title">instaGames</h1> --}}
        <img src="{{ asset('img/logo.png') }}" alt="" style="width:20rem;">
    </div>

    @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif

    <div class="">
        <h1>Populära spel</h1>
        <div style="display:flex; flex-wrap:wrap;">
            @foreach($products as $product)
                @include('product.default')
            @endforeach
        </div>
    </div>

    <div class="flex-center" style="background-color:rgba(0,0,0,.1);">
        <div class="" style="width:40rem; padding:5rem;">
            <h1 style="font-size:40pt; margin-bottom:0;">Tidsgaranti</h1>
            <p style="font-size:18pt;">Om din leverans inte kommer till dig inom 1 timme efter bekräftelse så får du låna spelet gratis! Detta garanti är satt pågrund av att kunna försäkra er om att ni blir erhållen bästa möjliga service.</p>
        </div>
    </div>
@stop
