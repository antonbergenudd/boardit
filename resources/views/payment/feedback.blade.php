@extends('layouts.default')

@section('content')
    <div class="feedback" data-order-status="{{Session::get('order_id')}}">
        <div class="feedback-wrapper">
        {{-- Display errors --}}
        {{-- @if($errors->any())
            <div class="" id="errors">
                <i class="material-icons" style="font-size:120pt; color:#96DDFF;">priority_high</i>
                <h1>Något gick fel.</h1>
                <h3>Oroa dig inte, ingen betalning har utförts!</h3>
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>

                    <div class="alert alert-danger">
                        <p>Innan du försöker igen, kontrollera att du</p>
                        <p>1. Låst upp internetbetalningar</p>
                        <p>2. Har tillräckligt med pengar på kontot</p>
                    </div>
                @endforeach
                <div class="">
                    <a href="{{ route('payment.index') }}" class="link">Gå tillbaka</a>
                </div>
            </div>
        @else --}}
            <div class="feedback-info">
                <div class="" style="text-align:center;">

                    {{-- SPINNER --}}
                    <i class="hide material-icons" data-order-status-failed style="font-size:70pt; color:#e3342f;">clear</i>
                    <i class="hide material-icons" data-order-status-confirmed style="font-size:70pt; color:#90EE90;">check_circle</i>
                    <img data-order-status-waiting style="height:100px;" src="http://rpg.drivethrustuff.com/shared_images/ajax-loader.gif"/>
                </div>

                <h2 class="hide" data-order-status-confirmed style="margin-top:0;">{{ Session::get('code') }}</h2>

                <div data-order-status-waiting>
                    <h2 style="margin-bottom:.5rem;">Vi kontrollerar så att vi har möjlighet att leverera din beställning..</h2>
                </div>

                <div class="hide" data-order-status-confirmed>
                    <h2>Din order är bekräftad!</h2>
                    <p style="margin:0;">Du kommer få en bekräftelse via sms inom kort.</p>
                </div>

                <h2 data-order-status-confirmed>Har du inte beställt upphämtning?</h2>
                <p data-order-status-confirmed style="margin:0;">Återlämning sker inom 24 timmar efter det att du fått spelet.</p>
                <p data-order-status-confirmed style="margin:0;">Adress för återlämning: <b>Vikingavägen 16b, 224 77, Lund</b></p>.

                <h2 data-order-status-confirmed>Tack för att du handlade hos på Boardit!</h2>

                <div class="hide" data-order-status-failed>
                    <h2>Tyvärr så kan vi inte leverera vid det utsatta datumet.</h2>
                    <h4>Oroa dig inte, inga pengar har dragits.</h4>
                    <p>Du är varmt välkommen tillbaka!</p>
                </div>

                <div class="">
                    <a href="{{ route('payment.index') }}" class="link">Gå tillbaka</a>
                </div>
            </div>
            {{-- <div class="feedback-info">
                <div class="" style="text-align:center;">
                    <i class="material-icons" style="font-size:70pt; color:#90EE90;">check_circle</i>
                    <h2 style="margin-top:0;">{{ $code }}</h2>
                </div>

                <p style="margin:0;">Använd denna kod om du har några funderingar runt din order. <br> Bekräftelse kommer skickas via sms inom kort.</p>

                <h2 style="margin-bottom:.5rem;">Datum för leverans</h4>
                <p style="margin:0;">{{ $deliverance_date }}</p>

                <h2 style="margin-bottom:.5rem;">Har du inte beställt upphämtning?</h2>
                <p style="margin:0;">Återlämning sker inom 24 timmar efter det att du fått spelet.</p>
                <p style="margin:0;">Adress för återlämning: <b>Vikingavägen 16b, 224 77, Lund</b></p>.

                <h2>Tack för att du handlade hos på Boardit!</h2>

                <div class="">
                    <a href="{{ route('payment.index') }}" class="link">Gå tillbaka</a>
                </div>
            </div> --}}
        {{-- @endif --}}
        </div>
    </div>
@stop
