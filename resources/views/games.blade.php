@extends('layouts.default')

@section('content')
<div class="games">
    <div class="games-categories" style="text-align:left;">
        <ul style="margin-top:4rem; list-style:none; border-right: 1px solid rgba(0, 0, 0, .3)">
        @foreach($categories as $category)
            <li><a href="#">{{ $category->name }}</a></li>
        @endforeach
        </ul>
    </div>
    <div class="games-wrapper">
        @foreach($products as $product)
            @include('product.default')
        @endforeach
    </div>

    {{-- @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif --}}
</div>
@stop
