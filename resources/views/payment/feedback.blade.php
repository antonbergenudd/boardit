@extends('layouts.default')

@section('content')
    <div class="feedback" data-order-status="{{Session::get('order_id')}}">
        <div class="feedback-wrapper">
        {{-- Display errors --}}
            <div class="feedback-info">
                @if($errors->any())
                    <div class="" style="text-align:center;">
                        <i class="material-icons" data-order-status-failed style="font-size:70pt; color:#e3342f;">priority_high</i>
                    </div>

                    <h2>Något gick fel.</h2>
                    <h3>Oroa dig inte, ingen betalning har utförts!</h3>

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach

                    <h2>Tips</h2>
                    <p style="margin:0;">Innan du försöker igen, kontrollera att du</p>
                    <p style="margin:0;">1. Låst upp internetbetalningar</p>
                    <p style="margin:0;">2. Har tillräckligt med pengar på kontot</p>
                @else
                    <div id="my-checkout-container"></div>
                    
                    <textarea style="display: none" id="KCO">
                        {!! $html_snippet !!}
                    </textarea>

                    {{-- <textarea style="display:none;" id="KCO">
                        <div id=\"klarna-checkout-container\" style=\"overflow-x: hidden;\">\n  <div id=\"klarna-unsupported-page\">\n  <style type=\"text/css\">\n  @-webkit-keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}@-moz-keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}@keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}#klarna-unsupported-page{opacity:0;opacity:1\\9;-webkit-animation:klarnaFadeIn ease-in 1;-moz-animation:klarnaFadeIn ease-in 1;animation:klarnaFadeIn ease-in 1;-webkit-animation-fill-mode:forwards;-moz-animation-fill-mode:forwards;animation-fill-mode:forwards;-webkit-animation-duration:.1s;-moz-animation-duration:.1s;animation-duration:.1s;-webkit-animation-delay:5s;-moz-animation-delay:5s;animation-delay:5s;text-align:center;padding-top:64px}#klarna-unsupported-page .heading{font-family:Source Sans Pro,Helvetica,Arial,sans-serif;line-height:48px;font-weight:200;color:#303030;font-size:42px;margin:24px 0}#klarna-unsupported-page .subheading{font-family:Source Sans Pro,Helvetica,Arial,sans-serif;line-height:28px;font-weight:400;color:rgba(0,0,0,.7);font-size:19px;max-width:560px;margin:10px auto}#klarna-unsupported-page .subheading a{text-decoration:none;background-color:transparent;border:0;color:rgba(0,0,0,.7);font-weight:600}\n  </style>\n  <h1 class=\"heading\">Oops.</h1>\n    <p class=\"subheading\">It looks like an important part of the checkout experience failed to load and we are unable to offer you a way to pay right now.</p>\n    <p class=\"subheading\">Please refresh the page to try again. If this isn't the first time you've seen this message then there may be a more permanent error and you should contact customer service at Klarna.com.</p>\n  </div>\n  <script type=\"text/javascript\">\n  /* <![CDATA[ */\n  (function(w,k,i,d,n,c,l){\n    w[k]=w[k]||function(){(w[k].q=w[k].q||[]).push(arguments)};\n    l=w[k].config={\n      container:w.document.getElementById(i),\n      ORDER_URL:'https://checkout-eu.playground.klarna.com/yaco/orders/c403c5a7-df69-54df-981d-b712d804477e',\n      AUTH_HEADER:'KlarnaCheckout h1s4sia1cv0o9agigw1m',\n      LOCALE:'en-SE',\n      ORDER_STATUS:'checkout_complete',\n      MERCHANT_TAC_URI:'https://www.example.com/terms.html',\n      MERCHANT_NAME:'Your business name',\n      HASHED_MERCHANT_ID:'dc7769f9f1146f950901ce88f3a8d53b',\n      GUI_OPTIONS:[],\n      ALLOW_SEPARATE_SHIPPING_ADDRESS:false,\n      PURCHASE_COUNTRY:'swe',\n      PURCHASE_CURRENCY:'SEK',\n      TESTDRIVE:true,\n      CHECKOUT_DOMAIN:'https://checkout-eu.playground.klarna.com',\n      BOOTSTRAP_SRC:'https://x.klarnacdn.net/kcoc/191125-128d9bc/checkout.bootstrap.js',\n      CLIENT_EVENT_HOST:'https://evt.playground.klarna.com',\n      LIQUORICE_ENABLED:false\n    };\n    n=d.createElement('script');\n    c=d.getElementById(i);\n    n.async=!0;\n    n.src=l.BOOTSTRAP_SRC;\n    c.appendChild(n);\n    try{\n      ((w.Image && (new w.Image))||(d.createElement && d.createElement('img'))||{}).src =\n        l.CLIENT_EVENT_HOST + '/v1/checkout/snippet/load' +\n        '?sid=' + l.ORDER_URL.split('/').slice(-1) +\n        '&order_status=' + w.encodeURIComponent(l.ORDER_STATUS) +\n        '&timestamp=' + (new Date).getTime();\n    }catch(e){}\n  })(this,'_klarnaCheckout','klarna-checkout-container',document);\n  /* ]]> */\n  </script>\n  <noscript>\nPlease <a href=\"http://enable-javascript.com\">enable JavaScript</a>.\n  </noscript>\n</div>
                    </textarea> --}}

                    <!-- <div class="" style="text-align:center;">
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
                    </div> -->
                @endif

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
