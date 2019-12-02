@extends('layouts.default')

@section('content')
    <div class="payment">
        <div class="payment-left flex-center">
            <div class="pay-method" id="pay_method">

                {{-- <div class="payment-select" id="select_pay_method">
                    <div id="my-checkout-container"></div>
                    <textarea style="display: none" id="KCO">
                        {!! $html_snippet !!}
                    </textarea>
                </div> --}}

                <div class="">
                    <div id="klarna-payments-container" style="width:280px;"></div>
                </div>

                <script type="text/javascript">
                    window.klarnaAsyncCallback = function () {

                        // This is where you start calling Klarna's JS SDK functions

                        Klarna.Payments.init({
                            client_token: localStorage.getItem("klarna_client_token"),
                        })

                        Klarna.Payments.load({
                            container: '#klarna-payments-container',
                            payment_method_category: 'pay_now',
                          }, function (res) {
                            // console.log(res);
                        })

                        Klarna.Payments.authorize({
                          payment_method_category: "pay_now",
                        }, {
                          purchase_country: "SE",
                          purchase_currency: "SEK",
                          locale: "sv-SE",
                          billing_address: {
                            given_name: "Håkan",
                            family_name: "Larsson",
                            email: "hakan.larsson.test@klarna.com",
                            street_address: "Lars Väg 399",
                            postal_code: "11354",
                            city: "Stockholm",
                            phone: "0765260000",
                            country: "SE"
                          },
                          shipping_address: {
                            given_name: "Håkan",
                            family_name: "Larsson",
                            email: "hakan.larsson.test@klarna.com",
                            street_address: "Lars Väg 399",
                            postal_code: "11354",
                            city: "Stockholm",
                            phone: "0765260000",
                            country: "SE"
                          },
                          order_amount: 10,
                          order_tax_amount: 0,
                          order_lines: [{
                            type: "physical",
                            reference: "19-402",
                            name: "Battery Power Pack",
                            quantity: 1,
                            unit_price: 10,
                            tax_rate: 0,
                            total_amount: 10,
                            total_discount_amount: 0,
                            total_tax_amount: 0,
                            product_url: "https://www.estore.com/products/f2a8d7e34",
                            image_url: "https://www.exampleobjects.com/logo.png"
                          }],
                          customer: {
                            national_identification_number: "410321-9202",
                            gender: "male"
                          },
                        }, function(res) {
                          console.log(res);
                        })

                        Klarna.Payments.finalize(
                          {payment_method_category: "pay_now"},
                          {},
                          function(res) {
                              console.log(res);
                          // res = {
                          //   show_form: true,
                          //   approved: true,
                          //   authorization_token: ...
                          // }
                        })
                    };
                </script>



                <!--
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
                </form>-->
            </div>
        </div>

        <div class="payment-divider"></div>

        <div class="payment-right">
            <div style="height:80%;">
                @include('modules.cart.full')
            </div>
        </div>
    </div>
@endsection
