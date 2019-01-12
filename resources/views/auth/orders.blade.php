@extends('layouts.default')
@section('content')
    <div class="" style="height:100vh;">
        <h1>List all orders</h1>
        <div class="" style="display:flex;">
            @foreach($orders as $order)
                <div class="">
                    <h4>Products</h4>
                    @foreach($order->getProducts()->get() as $product)
                        <p>{{$product->name}}</p>
                    @endforeach
                    <h4>Confirmed</h4>
                    @if($order->confirmed)
                        <p>true</p>
                    @else
                        <p>false</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@stop
