@extends('layouts.default')

@section('content')
    <div class="payment" data-checkout>
        <div class="payment-left">
            <textarea style="display: none;" id="KCO" data-checkout-cart="{{$cart}}">
                {{-- <div id=\"klarna-checkout-container\" style=\"overflow-x: hidden;\">\n  <div id=\"klarna-unsupported-page\">\n  <style type=\"text/css\">\n  @-webkit-keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}@-moz-keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}@keyframes klarnaFadeIn{from{opacity:0}to{opacity:1}}#klarna-unsupported-page{opacity:0;opacity:1\\9;-webkit-animation:klarnaFadeIn ease-in 1;-moz-animation:klarnaFadeIn ease-in 1;animation:klarnaFadeIn ease-in 1;-webkit-animation-fill-mode:forwards;-moz-animation-fill-mode:forwards;animation-fill-mode:forwards;-webkit-animation-duration:.1s;-moz-animation-duration:.1s;animation-duration:.1s;-webkit-animation-delay:5s;-moz-animation-delay:5s;animation-delay:5s;text-align:center;padding-top:64px}#klarna-unsupported-page .heading{font-family:Source Sans Pro,Helvetica,Arial,sans-serif;line-height:48px;font-weight:200;color:#303030;font-size:42px;margin:24px 0}#klarna-unsupported-page .subheading{font-family:Source Sans Pro,Helvetica,Arial,sans-serif;line-height:28px;font-weight:400;color:rgba(0,0,0,.7);font-size:19px;max-width:560px;margin:10px auto}#klarna-unsupported-page .subheading a{text-decoration:none;background-color:transparent;border:0;color:rgba(0,0,0,.7);font-weight:600}\n  </style>\n  <h1 class=\"heading\">Oops.</h1>\n    <p class=\"subheading\">It looks like an important part of the checkout experience failed to load and we are unable to offer you a way to pay right now.</p>\n    <p class=\"subheading\">Please refresh the page to try again. If this isn't the first time you've seen this message then there may be a more permanent error and you should contact customer service at Klarna.com.</p>\n  </div>\n  <script type=\"text/javascript\">\n  /* <![CDATA[ */\n  (function(w,k,i,d,n,c,l){\n    w[k]=w[k]||function(){(w[k].q=w[k].q||[]).push(arguments)};\n    l=w[k].config={\n      container:w.document.getElementById(i),\n      ORDER_URL:'https://js.playground.klarna.com/eu/kco/checkout/orders/aa4e7b19-4e92-60cd-9081-b7024e870e07',\n      AUTH_HEADER:'KlarnaCheckout 8w7iantbidl9cyhnubev',\n      LOCALE:'en-SE',\n      ORDER_STATUS:'checkout_incomplete',\n      MERCHANT_TAC_URI:'https://www.example.com/terms.html',\n      MERCHANT_NAME:'Your business name',\n      HASHED_MERCHANT_ID:'4a38c9820494ae4daeb5b47a4ec0d977',\n      GUI_OPTIONS:[],\n      ALLOW_SEPARATE_SHIPPING_ADDRESS:false,\n      PURCHASE_COUNTRY:'swe',\n      PURCHASE_CURRENCY:'SEK',\n      TESTDRIVE:true,\n      CHECKOUT_DOMAIN:'https://checkout-eu.playground.klarna.com',\n      BOOTSTRAP_SRC:'https://js.playground.klarna.com/kcoc/201203-8da3a3b/checkout.bootstrap.js',\n      CLIENT_EVENT_HOST:'https://eu.playground.klarnaevt.com',\n      LIQUORICE_ENABLED:false,\n      CONDENSED_ENABLED:false\n    };\n    n=d.createElement('script');\n    c=d.getElementById(i);\n    n.async=!0;\n    n.src=l.BOOTSTRAP_SRC;\n    c.appendChild(n);\n    try{\n      ((w.Image && (new w.Image))||(d.createElement && d.createElement('img'))||{}).src =\n        l.CLIENT_EVENT_HOST + '/v1/checkout/snippet/load' +\n        '?sid=' + l.ORDER_URL.split('/').slice(-1) +\n        '&order_status=' + w.encodeURIComponent(l.ORDER_STATUS) +\n        '&timestamp=' + (new Date).getTime();\n    }catch(e){}\n  })(this,'_klarnaCheckout','klarna-checkout-container',document);\n  /* ]]> */\n  </script>\n  <noscript>\nPlease <a href=\"http://enable-javascript.com\">enable JavaScript</a>.\n  </noscript>\n</div> --}}
            </textarea>
            
            <div id="my-checkout-container"></div>
        
        </div>

        <div class="payment-divider"></div>

        <div class="payment-right">
            {{-- <div style="height:80%;">
                @include('modules.cart.full')
            </div> --}}
        </div>
    </div>
@endsection
