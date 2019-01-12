@extends('layouts.default')
@section('content')
    <div class="flex-center" style="width:100%; height:40vh; background-color:black;">
        <h1>Alla spel</h1>
    </div>

    <div class="" style="width:100%; display:flex; flex-wrap:wrap; padding:1rem;">
        <div style="display:flex; flex-wrap:wrap;">
            @foreach($products as $product)
                @include('product.default')
            @endforeach
        </div>
    </div>

    @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif
@stop
