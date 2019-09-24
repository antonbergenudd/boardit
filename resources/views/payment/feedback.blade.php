@extends('layouts.default')

@section('content')
    <div class="feedback">
        <div class="feedback-wrapper">
        {{-- Display errors --}}
        @if($errors->any())
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
        @else
            <div class="payment-code">
                <div class="" style="text-align:center;">
                    <i class="material-icons" style="font-size:70pt; color:#90EE90;">check_circle</i>
                    <h2 style="margin-top:0;">{{ $code }}</h2>
                </div>

                <p style="margin:0;">Använd denna kod om du har några funderingar runt din order. <br> Bekräftelse kommer skickas via sms samt email inom kort.</p>

                <h2 style="margin-bottom:.5rem;">Har du inte beställt upphämtning?</h2>
                <p style="margin:0;">Återlämning sker inom 24 timmar efter det att du fått spelet.</p>
                <p style="margin:0;">Adress för återlämning: <b>Vikingavägen 16b, 224 77, Lund</b></p>.
                <br>
                <h2>Tack för att du handlade hos på <b>Boardit</b>!</h2>
                <div class="">
                    <a href="{{ route('payment.index') }}" class="link">Gå tillbaka</a>
                </div>
            </div>
        @endif
        </div>
    </div>
@stop
