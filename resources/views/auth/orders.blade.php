@extends('layouts.auth')
@section('content')
<div class="orders">
    <h1>Aktivitet</h1>
    <div class="orders-actions">
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
    <div>
        <hr class="order-divider">
        @foreach($orders->sortBy('deliverance_date') as $order)
            <div class="order" class="@if($order->status == \boardit\Order::RETURNED) lock-order @endif @if($order->error) order-error @endif">
                <div class="order-subitem">
                    <h4>Beställning</h4>
                    <div class="">
                        @foreach($order->getProducts()->get() as $product)
                            <p style="margin:0; margin-bottom:.2rem;">{{$product->name}}</p>
                        @endforeach
                    </div>
                </div>
                <div class="order-subitem">
                    <h4>Adress</h4>
                    <p>{{$order->address}}</p>
                </div>
                <div class="order-subitem">
                    <h4>Beställt</h4>
                    <p>{{$order->created_at->format('Y-m-d G:i')}}</p>
                </div>
                @if(isset($note))
                <div class="order-subitem">
                    <h4>Special note</h4>
                    <p>{{$order->note}}</p>
                </div>
                @endif
                <div class="order-subitem">
                    <h4>Upphämtning</h4>
                    <p>
                        @if($order->collect) Ja @else Nej @endif
                    </p>
                </div>
                <div class="order-subitem">
                    <h4>Kod</h4>
                    <p>{{$order->code}}</p>
                </div>
                <div class="order-subitem">
                    <h4>Bekräftat av</h4>
                    @if($order->status >= \boardit\Order::CONFIRMED)
                        <p>{{$order->confirmedBy->name}}</p>
                    @else
                        <p>Ingen</p>
                    @endif
                </div>
                <div class="order-subitem">
                    <h4>Leverans datum</h4>
                    <p>{{$order->deliverance_date}}</p>
                </div>

                <div class="order-subitem">
                    <h4 style="margin-bottom:.5rem;">Action</h4>
                    @if($order->deliverance_date <= Carbon\Carbon::now('Europe/Stockholm')->addHours('2') && $order->status == \boardit\Order::IDLE)
                        <div class="order-action">
                            <a href="{{route('auth.confirm.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">
                                Bekräfta
                            </a>
                        </div>
                    @elseif($order->status == \boardit\Order::CONFIRMED)
                        <div class="order-action">
                            <a href="{{route('auth.deliver.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">
                                Levererat
                            </a>
                        </div>
                    @elseif($order->status == \boardit\Order::DELIVERED)
                        <div class="order-action">
                            <a href="{{route('auth.return.order', ['order' => $order->id, 'user' => Auth::user()->id])}}" class="link">
                                Återlämna
                            </a>
                        </div>
                    @elseif($order->status == \boardit\Order::RETURNED)
                        <p>Behandlat</p>
                    @else
                        <p>Väntandes</p>
                    @endif
                </div>
            </div>
            <hr class="order-divider">
        @endforeach
    </div>
</div>
@stop
