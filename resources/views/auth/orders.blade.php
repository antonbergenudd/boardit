@extends('layouts.auth')
@section('content')
    <div style="height:100vh; margin-top:5rem;">
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
                    <a href="{{route('auth.confirm.order', ['order' => $order->id])}}" class="link">Confirm</a>
                </div>
            @endforeach
        </div>
    </div>
@stop
