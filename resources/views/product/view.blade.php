@extends('layouts.default')
@section('content')
    <div class="flex-center product-view">
        <div class="flex-center product-view-wrapper">
            <div class="flex-center product-view-wrapper-image">
                <img src="{{ asset('img/games/'.$product->thumbnail) }}">
            </div>
            <div class="product-view-wrapper-text">
                <h1>{{$product->name}}</h1>
                <p>{{$product->description}}</p>
            </div>
        </div>
    </div>
@stop
