@extends('layouts.default')
@section('content')
    <div class="" style="margin-top:5rem; width:100%; display:flex; flex-wrap:wrap; padding:1rem;">
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
