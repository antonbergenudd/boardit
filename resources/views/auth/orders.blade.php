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
                <div style="display:flex; flex-wrap:wrap;" class="@if($order->returned && $order->confirmed) lock-order @endif">
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
                        <h4>Leverering</h4>
                        <p>
                        @if($order->deliver)
                            Utkörning
                        @endif
                        @if($order->collect && $order->deliver)
                            &
                        @endif
                        @if($order->collect)
                            Upphämtning
                        @endif

                        @if(!$order->collect && !$order->deliver)
                            N/A
                        @endif
                        </p>
                    </div>
                    <div class="" style="flex:1;">
                        <h4>Kod</h4>
                        <p>{{$order->code}}</p>
                    </div>
                    <div class="" style="flex:1; min-width:10rem;">
                        <h4>Bekräftat av</h4>
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
                    @endif
                    @if($order->confirmed)
                        @if($order->returned)
                            <div class="flex-center" style="flex:1;">
                                Återlämnat
                            </div>
                        @else
                            <div class="flex-center" style="flex:1;">
                                <a style="border:1px solid #4CC94C; color:#4CC94C; padding:1rem; margin-left:1rem;" href="{{route('auth.return.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">Återlämna</a>
                            </div>
                        @endif
                    @endif
                </div>
                <hr style="width:90%; opacity:.5;">
            @endforeach
        </div>
    </div>
@stop
