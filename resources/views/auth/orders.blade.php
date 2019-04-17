@extends('layouts.auth')
@section('content')
    <div style="height:100vh; margin-top:5rem;">
        <h1>Activity</h1>
        <div class="" style="width:100%;">

            @if(! Auth::user()->delivering)
            <form action="{{ route('auth.delivering', ['user' => Auth::user()->id])}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="delivering" value="1">
                <button type="submit" name="button">Can deliver</button>
            </form>
            @else
            <form action="{{ route('auth.delivering', ['user' => Auth::user()->id])}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="delivering" value="0">
                <button type="submit" name="button">Stop delivering</button>
            </form>
            @endif
        </div>
        <h1>List all orders</h1>
        <div class="" style="">
            <hr style="width:90%; opacity:.5;">
            @foreach($orders as $order)
                <div style="display:flex; flex-wrap:wrap;">
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Products</h4>
                        <div class="">
                            @foreach($order->getProducts()->get() as $product)
                                <p style="margin:0; margin-bottom:.2rem;">{{$product->name}}</p>
                            @endforeach
                        </div>
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
                        <h4>Payment Type</h4>
                        <p>{{$order->payment_type}}</p>
                    </div>
                    <div class="" style="flex:1;">
                        <h4>Code</h4>
                        <p>{{$order->code}}</p>
                    </div>
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Confirmed by</h4>
                            @if($order->confirmed)
                                <p>{{$order->confirmedBy->name}}</p>
                            @else
                                <p>false</p>
                            @endif
                    </div>
                    @if(!$order->confirmed)
                    <div class="flex-center" style="flex:1;">
                        <a style="border:1px solid #4CC94C; color:#4CC94C; padding:1rem; margin-left:1rem;" href="{{route('auth.confirm.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">Confirm</a>
                    </div>
                    @else
                    <div class="" style="flex:1;">
                        <h4>Confirmed at</h4>
                            <p>{{$order->updated_at->format('Y-m-d G:i')}}</p>
                    </div>
                    @endif
                </div>
                <hr style="width:90%; opacity:.5;">
            @endforeach
        </div>
    </div>
@stop
