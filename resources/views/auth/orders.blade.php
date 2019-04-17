@extends('layouts.auth')
@section('content')
    <div style="height:100vh; margin-top:5rem;">
        <h1>Activity</h1>
        <div class="" style="width:100%;">
            <button type="button" name="button">Can deliver</button>
        </div>
        <h1>List all orders</h1>
        <div class="" style="">
            <hr style="width:90%; opacity:.5;">
            @foreach($orders as $order)
                <div style="display:flex; flex-wrap:wrap;">
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Products</h4>
                        @foreach($order->getProducts()->get() as $product)
                            <p>{{$product->name}}</p>
                        @endforeach
                    </div>
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Adress</h4>
                        <p>{{$order->address}}</p>
                    </div>
                    @if(isset($note))
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Special note</h4>
                        <p>{{$order->note}}</p>
                    </div>
                    @endif
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Payment</h4>
                        <p>{{$order->payment_type}}</p>
                        <p>{{$order->payment}} kr</p>
                    </div>
                    <div class="" style="flex:1;">
                        <h4>Code</h4>
                        <p>{{$order->code}}</p>
                    </div>
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Confirmed</h4>
                        @if($order->confirmed)
                            <p>true</p>
                        @else
                            <p>false</p>
                        @endif
                        <a href="{{route('auth.confirm.order', ['order' => $order->id])}}" class="link">Confirm</a>
                    </div>
                </div>
                <hr style="width:90%; opacity:.5;">
            @endforeach
        </div>
    </div>
@stop
