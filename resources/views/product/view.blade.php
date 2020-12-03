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
                <div style="display: flex;">
                    @foreach($product->getCategories as $category)
                    <p style="margin-right:1rem; padding:0.5rem 1rem; background-color:rgb(219, 219, 219);">{{ $category->name }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
