@extends('layouts.default')

@section('content')
    <div class="payment">
        <div class="payment-left">
            <!-- <div class="pay-method flex-center" id="pay_method">

                {{-- Select pay method --}}
                <div class="payment-select flex-center" id="select_pay_method">
                    <div class="payment-select-card flex-center">
                        <p class="link" data-pay-method="card">Kort</p>
                    </div>

                    <div class="payment-select-divider flex-center">
                        <div class="divider-line"></div>
                        <h4>eller</h4>
                        <div class="divider-line"></div>
                    </div>

                    {{-- <div class="payment-select-swish flex-center" >
                        <p class="link" data-pay-method="swish">Swish</p>
                    </div> --}}

                    <div class="payment-select-swish flex-center" style="cursor:not-allowed;" >
                        <p>Swish</p>
                    </div>
                </div>

                <form class="payment-form hide" id="payment_form" action="{{ route('payment.submit') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" data-env="{{env('STRIPE_TEST_MODE')}}">

                    <div class="payment-form-header hide" data-payment-swish>
                        <h1>Swish</h1>
                        <h1>1231802255</h1>
                    </div>

                    <h2>Datum för leverans</h2>
                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="date">Datum</label>
                            <input data-validate-date name="date" style="font-family:inherit;" type="date" min="{{ Carbon\Carbon::now('Europe/Stockholm')->format('Y-m-d')}}" value="{{ Carbon\Carbon::now('Europe/Stockholm')->hour < 22 && Carbon\Carbon::now('Europe/Stockholm')->hour > 12 ? Carbon\Carbon::now('Europe/Stockholm')->format('Y-m-d') : Carbon\Carbon::now('Europe/Stockholm')->addDays('1')->format('Y-m-d') }}">
                        </div>
                        <div class="input-box-wrapper">
                            <label for="date_hour">Tid</label>
                            <div class="" style="display:flex;">
                                <input data-validate-hour name="date_hour" style="width:1rem; text-align: center; padding: 0.56rem; font-family: inherit;" type="number" min="12" max="23" value="{{ Carbon\Carbon::now('Europe/Stockholm')->hour < 22 && Carbon\Carbon::now('Europe/Stockholm')->hour > 12 ? Carbon\Carbon::now('Europe/Stockholm')->addHours('1')->format('H') : 12 }}">
                                <span style="border-bottom:1px solid #96DDFF; height:calc(100% - 1px); display:flex; align-items:center;">:</span>
                                <input data-validate-minute name="date_minute" style="width:100%; text-align: left; padding: 0.56rem; font-family: inherit;" type="number" value="{{ Carbon\Carbon::now('Europe/Stockholm')->format('i')}}" max="59" min="0">
                            </div>
                        </div>
                    </div>

                    <h2>Kontaktuppgifter</h2>
                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="tel">Telefonnummer</label>
                            <input type="number" name="tel" placeholder="0700112233" data-validate-required>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="tel">Email</label>
                            <input type="email" name="email" placeholder="min@email.com" data-validate-required data-validate-email>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="address">Gata</label>
                            <input type="text" name="street" placeholder="Bangatan 123" required data-validate-required>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="address">Stad</label>
                            <input type="text" name="city" value="Lund" required data-validate-required data-validate-city readonly>
                        </div>
                        <div class="input-box-wrapper">
                            <label for="address">Postnummer</label>
                            <input type="text" name="postcode" placeholder="222 21" required data-validate-required>
                        </div>
                    </div>

                    <h2>Övrigt</h2>
                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="note">Inför leverans</label>
                            <textarea name="note" rows="4" cols="80" placeholder="Text här.."></textarea>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="note">Rabattkod</label>
                            <input type="text" name="discount_code" placeholder="Kod här.." id="discount_code" data-validate-discount>
                            <input type="hidden" name="discount_amount" value="0">
                            <p class="hide">Rabatt tillagd: <span data-discount-number></span>%</p>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="user_consent">
                                <input name="user_consent" type="checkbox" data-validate-checkbox style="padding: 1rem 0;">
                                Läs igenom och godkänn våran <a class="link" href="{{ route('policy') }}" target="_blank">användarpolicy</a> innan du betalar!
                            </label>
                        </div>
                    </div>

                    <div class="actions" data-validate-submit>
                        @if($cartTotal > 0)
                        <p class="payment-form-submit-card hide"
                            data-payment-card
                            @if($cartTotal > 0)
                                data-stripe-pay
                                data-stripe-amount="{{ $cartTotal + 30 }}"
                            @endif
                            >
                            Betala
                        </p>

                        {{-- <button
                            data-payment-swish
                            @if($cartTotal > 0)
                                type="submit"
                            @endif
                            class="payment-form-submit-swish link hide"
                            >
                            Swish utfört
                        </button> --}}
                        @else
                            <h4>Kundvagnen är tom</h4>
                        @endif
                    </div>
                </form>
            </div> -->

            <textarea style="display: none;" id="KCO">
                {{-- <div id=\"klarna-checkout-container\" style=\"overflow-x: hidden;\">\n  <div id=\"klarna-unsupported-page\">\n  <style type=\"text/css\">\n  @-webkit-keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}@-moz-keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}@keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}#klarna-unsupported-page{opacity:0;opacity:1\\9;-webkit-animation:klarnaFadeIn ease-in 1;-moz-animation:klarnaFadeIn ease-in 1;animation:klarnaFadeIn ease-in 1;-webkit-animation-fill-mode:forwards;-moz-animation-fill-mode:forwards;animation-fill-mode:forwards;-webkit-animation-duration:.1s;-moz-animation-duration:.1s;animation-duration:.1s;-webkit-animation-delay:5s;-moz-animation-delay:5s;animation-delay:5s;text-align:center;padding-top:64px}#klarna-unsupported-page .heading{font-family:Source Sans Pro,Helvetica,Arial,sans-serif;line-height:48px;font-weight:200;color:#303030;font-size:42px;margin:24px 0}#klarna-unsupported-page .subheading{font-family:Source Sans Pro,Helvetica,Arial,sans-serif;line-height:28px;font-weight:400;color:rgba(0,0,0,.7);font-size:19px;max-width:560px;margin:10px auto}#klarna-unsupported-page .subheading a{text-decoration:none;background-color:transparent;border:0;color:rgba(0,0,0,.7);font-weight:600}\n  </style>\n  <h1 class=\"heading\">Oops.</h1>\n    <p class=\"subheading\">It looks like an important part of the checkout experience failed to load and we are unable to offer you a way to pay right now.</p>\n    <p class=\"subheading\">Please refresh the page to try again. If this isn't the first time you've seen this message then there may be a more permanent error and you should contact customer service at Klarna.com.</p>\n  </div>\n  <script type=\"text/javascript\">\n  /* <![CDATA[ */\n  (function(w,k,i,d,n,c,l){\n    w[k]=w[k]||function(){(w[k].q=w[k].q||[]).push(arguments)};\n    l=w[k].config={\n      container:w.document.getElementById(i),\n      ORDER_URL:'https://js.playground.klarna.com/eu/kco/checkout/orders/45cbbbcd-9f04-613f-ba48-18767b2708e7',\n      AUTH_HEADER:'KlarnaCheckout ib3zj10635frm43stbtt',\n      LOCALE:'en-SE',\n      ORDER_STATUS:'checkout_incomplete',\n      MERCHANT_TAC_URI:'https://www.example.com/terms.html',\n      MERCHANT_NAME:'Your business name',\n      HASHED_MERCHANT_ID:'4a38c9820494ae4daeb5b47a4ec0d977',\n      GUI_OPTIONS:[],\n      ALLOW_SEPARATE_SHIPPING_ADDRESS:false,\n      PURCHASE_COUNTRY:'swe',\n      PURCHASE_CURRENCY:'SEK',\n      TESTDRIVE:true,\n      CHECKOUT_DOMAIN:'https://checkout-eu.playground.klarna.com',\n      BOOTSTRAP_SRC:'https://js.playground.klarna.com/kcoc/201118-0eca8c1/checkout.bootstrap.js',\n      CLIENT_EVENT_HOST:'https://eu.playground.klarnaevt.com',\n      LIQUORICE_ENABLED:false,\n      CONDENSED_ENABLED:false\n    };\n    n=d.createElement('script');\n    c=d.getElementById(i);\n    n.async=!0;\n    n.src=l.BOOTSTRAP_SRC;\n    c.appendChild(n);\n    try{\n      ((w.Image && (new w.Image))||(d.createElement && d.createElement('img'))||{}).src =\n        l.CLIENT_EVENT_HOST + '/v1/checkout/snippet/load' +\n        '?sid=' + l.ORDER_URL.split('/').slice(-1) +\n        '&order_status=' + w.encodeURIComponent(l.ORDER_STATUS) +\n        '&timestamp=' + (new Date).getTime();\n    }catch(e){}\n  })(this,'_klarnaCheckout','klarna-checkout-container',document);\n  /* ]]> */\n  </script>\n  <noscript>\nPlease <a href=\"http://enable-javascript.com\">enable JavaScript</a>.\n  </noscript>\n</div> --}}
            </textarea>
            
            <div id="my-checkout-container"></div>
        
            {{-- <script type="text/javascript">
                var checkoutContainer = document.getElementById('my-checkout-container')
                checkoutContainer.innerHTML = (document.getElementById("KCO").value).replace(/\\"/g, "\"").replace(/\\n/g, "");
                var scriptsTags = checkoutContainer.getElementsByTagName('script')
                for (var i = 0; i < scriptsTags.length; i++) {
                    var parentNode = scriptsTags[i].parentNode
                    var newScriptTag = document.createElement('script')
                    newScriptTag.type = 'text/javascript'
                    newScriptTag.text = scriptsTags[i].text
                    parentNode.removeChild(scriptsTags[i])
                    parentNode.appendChild(newScriptTag)
                }
            </script> --}}



            {{-- <div style="border: 1px solid black; padding:1rem;">
                <div class="pay-later-container">
                    <div class="input-container" style="display:flex;">
                        <div style="">
                            <input type="radio" checked></button>
                        </div>
                        <div style="width:100%;">
                            <p style="margin:0;">Bankkonto</p>
                        </div>
                        <div>
                            <img style="height:20px;" src="https://x.klarnacdn.net/payment-method/assets/badges/generic/klarna.svg" alt="">
                        </div>
                    </div>

                    <div class="klarna-payment-container">
                        <div id="klarna-payments-container"></div>
                    </div>
                </div>

                <hr>

                <div class="pay-later-container">
                    <div class="input-container" style="display:flex;">
                        <div style="">
                            <input type="radio"></button>
                        </div>
                        <div style="width:100%;">
                            <p style="margin:0;">Få först betala sen</p>
                        </div>
                        <div>
                            <img style="height:20px;" src="https://x.klarnacdn.net/payment-method/assets/badges/generic/klarna.svg" alt="">
                        </div>
                    </div>

                    <div class="klarna-payment-container" style="display:none;">
                        <div id="klarna-payments-container"></div>
                    </div>
                </div>

                <hr>

                <div class="pay-later-container">
                    <div class="input-container" style="display:flex;">
                        <div style="">
                            <input type="radio"></button>
                        </div>
                        <div style="width:100%;">
                            <p style="margin:0;">Dela upp</p>
                        </div>
                        <div>
                            <img style="height:20px;" src="https://x.klarnacdn.net/payment-method/assets/badges/generic/klarna.svg" alt="">
                        </div>
                    </div>

                    <div class="klarna-payment-container" style="display:none;">
                        <div id="klarna-payments-container"></div>
                    </div>
                </div>
            </div>

            <script>
                window.klarnaAsyncCallback = function () {
                    Klarna.Payments.init({
                        client_token: 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjgyMzA1ZWJjLWI4MTEtMzYzNy1hYTRjLTY2ZWNhMTg3NGYzZCJ9.ewogICJzZXNzaW9uX2lkIiA6ICJhMGFlOTYzNC0wM2FlLTIwYzgtOGQwYi1hZDNmZGFkYWM5NDQiLAogICJiYXNlX3VybCIgOiAiaHR0cHM6Ly9rbGFybmEtcGF5bWVudHMtZXUucGxheWdyb3VuZC5rbGFybmEuY29tL3BheW1lbnRzIiwKICAiZGVzaWduIiA6ICJrbGFybmEiLAogICJsYW5ndWFnZSIgOiAiZW4iLAogICJwdXJjaGFzZV9jb3VudHJ5IiA6ICJHQiIsCiAgInRyYWNlX2Zsb3ciIDogZmFsc2UsCiAgImVudmlyb25tZW50IiA6ICJwbGF5Z3JvdW5kIiwKICAibWVyY2hhbnRfbmFtZSIgOiAiWW91ciBidXNpbmVzcyBuYW1lIiwKICAic2Vzc2lvbl90eXBlIiA6ICJQQVlNRU5UUyIsCiAgImNsaWVudF9ldmVudF9iYXNlX3VybCIgOiAiaHR0cHM6Ly9ldS5wbGF5Z3JvdW5kLmtsYXJuYWV2dC5jb20iLAogICJleHBlcmltZW50cyIgOiBbIHsKICAgICJuYW1lIiA6ICJpbi1hcHAtc2RrLW5ldy1pbnRlcm5hbC1icm93c2VyIiwKICAgICJwYXJhbWV0ZXJzIiA6IHsKICAgICAgInZhcmlhdGVfaWQiIDogIm5ldy1pbnRlcm5hbC1icm93c2VyLWVuYWJsZSIKICAgIH0KICB9IF0KfQ.AZwMchshuGdlvymuRL7uMjTgGokRoft-qY9TFT_sdczrXCkShEL-IIlcS5p70vQgHC4uZf0Bqs5IVR67Kq8o_9YIreSHlmSagSR9kTHtCwSHz0vuooAWKOOXWwKxW8Ms3U8LySIJpmx2EpxTSjUVU5wplIXiSpxOAJSFbrE1_ptvi_dG-8_FPKA3JsKenWiPqsa2wYQ13Bs2lEfPcFBmUR7PmrY8N_s6QyjajG1fqRgWqeoHr9siTIIvx3Cizq_2Heo2NqW2ly60_V_RG3WKWN_OV08lt-fmKF4J6kCfjNrO-blqZ7O07lMezhXcYY0vdUPx77-KJV5ygOlG-WDBHA'
                    })

                    Klarna.Payments.load({
                        container: '#klarna-payments-container',
                        payment_method_category: 'pay_now',
                    }, function (res) {
                        console.debug(res);
                    })
                };
            </script>

            <script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>

            <img src="https://cdn.klarna.com/1.0/shared/image/generic/badge/sv_se/checkout/long-blue.png?width=540" alt="" srcset=""> --}}
        </div>

        <div class="payment-divider"></div>

        <div class="payment-right">
            <div style="height:80%;">
                @include('modules.cart.full')
            </div>
        </div>
    </div>
@endsection
