@extends('layouts.default')

@section('content')
<div class="games">
    <div class="games-wrapper">
        @foreach($products as $product)
            @include('product.default')
        @endforeach
    </div>

    @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif
</div>
@stop
