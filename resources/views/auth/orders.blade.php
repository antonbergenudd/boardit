@extends('layouts.auth')
@section('content')
    <div style="height:100vh; margin-top:5rem;">
        <h1>Aktivitet</h1>
        <div class="" style="width:100%;">

            @if(! Auth::user()->delivering)
            <form action="{{ route('auth.delivering', ['user' => Auth::user()->id])}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="delivering" value="1">
                <button type="submit" name="button">Börja leverera</button>
            </form>
            @else
            <form action="{{ route('auth.delivering', ['user' => Auth::user()->id])}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="delivering" value="0">
                <button type="submit" name="button">Sluta leverera</button>
            </form>
            @endif
        </div>
        <h1>Alla beställningar</h1>
        <div class="" style="">
            <hr style="width:90%; opacity:.5;">
            @foreach($orders->sortByDesc('created_at') as $order)
                <div style="display:flex; flex-wrap:wrap;" class="@if($order->status == \boardit\Order::RETURNED) lock-order @endif @if($order->error) order-error @endif">
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Beställning</h4>
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
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Beställt</h4>
                        <p>{{$order->created_at->format('Y-m-d G:i')}}</p>
                    </div>
                    @if(isset($note))
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Special note</h4>
                        <p>{{$order->note}}</p>
                    </div>
                    @endif
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Upphämtning</h4>
                        <p>
                            @if($order->collect) Ja @else Nej @endif
                        </p>
                    </div>
                    <div class="" style="flex:1;">
                        <h4>Kod</h4>
                        <p>{{$order->code}}</p>
                    </div>
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Bekräftat av</h4>
                            @if($order->status !== \boardit\Order::IDLE)
                                <p>{{$order->confirmedBy->name}}</p>
                            @else
                                <p>Ingen</p>
                            @endif
                    </div>
                    @if($order->status == \boardit\Order::IDLE)
                        <div class="flex-center" style="flex:1;">
                            <a style="border:1px solid #4CC94C; color:#4CC94C; padding:1rem; margin-left:1rem;" href="{{route('auth.confirm.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">Bekräfta</a>
                        </div>
                    @elseif($order->status == \boardit\Order::RETURNED)
                        <div class="flex-center" style="flex:1;">
                            Återlämnat
                        </div>
                    @elseif($order->status == \boardit\Order::CONFIRMED)
                        <div class="flex-center" style="flex:1;">
                            <a style="border:1px solid #4CC94C; color:#4CC94C; padding:1rem; margin-left:1rem;" href="{{route('auth.deliver.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">Levererat</a>
                        </div>
                    @elseif($order->status == \boardit\Order::DELIVERED)
                        <div class="flex-center" style="flex:1;">
                            <a style="border:1px solid #4CC94C; color:#4CC94C; padding:1rem; margin-left:1rem;" href="{{route('auth.return.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">Återlämna</a>
                        </div>
                    @endif
                </div>
                <hr style="width:90%; opacity:.5;">
            @endforeach
        </div>
    </div>
@stop
