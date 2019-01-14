@extends('layouts.default')

@section('content')
    <div style="display:flex; margin-top:3rem;">
        <div class="flex-center" style="@if(Session::get('code')) flex-direction:column; @endif text-align:left; padding:5rem; width:calc(50% - 10rem); height:80vh;">
            @if(Session::get('code'))
                <h1>Din referens kod är {{ Session::get('code') }}</h1>
                <p>Bekräftelse kommer skickas via sms alternativt email</p>
            @else
                <div class="flex-center" style="height:100%;width:100%;" id="pay_method">

                    <form id="card" class="hide" action="index.html" method="post" style="margin:3rem; width:100%; min-width:10rem; margin-top:1rem;">
                        <h1>Kort</h1>

                        <div class="" style="display:flex; flex-direction:column; text-align:left; margin:1rem;">
                            <label for="" style="">Name of cardholder</label>
                            <input type="text" name="card_name" placeholder="John Doe" style="padding:0.5rem;">
                        </div>

                        <div class="" style="display:flex; flex-direction:column; text-align:left; margin:1rem;">
                            <label for="" style="">Card number</label>
                            <input type="text" name="card_number" placeholder="5050 2020 3030 4040" style="padding:0.5rem;">
                        </div>

                        <div class="" style="display:flex;">
                            <div class="" style="display:flex; flex-direction:column; text-align:left; margin:1rem; width:4rem;">
                                <label for="" style="">CVC</label>
                                <input type="text" name="card_cvc" placeholder="123" style="padding:0.5rem;">
                            </div>

                            <div class="" style="display:flex; flex-direction:column; text-align:left; margin:1rem;">
                                <label for="" style="">Expiration date</label>
                                <div class="" style="display:flex;">
                                    <input type="text" name="" placeholder="MM" style="margin-right:.5rem; padding:0.5rem; width:2rem;">
                                    <input type="text" name="" placeholder="YY" style="padding:0.5rem; width:2rem;">
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="button" class="link" style="margin-top:1rem; border-radius:0; border:2px solid rgba(0,0,0,.2); margin-left: 1rem; padding:1rem 2rem; background-color:white; font-size:12pt; font-weight:200;">Pay</button>
                    </form>

                    <form id="swish" class="hide" style="text-align:center;" action="{{ route('payment.confirm') }}" method="post">
                        {{ csrf_field() }}

                        <h1>Swish</h1>
                        <h1>123271238</h1>

                        <div class="" style="text-align: left;">
                            <div class="" style="margin-bottom:1rem; display:flex; flex-direction:column;">
                                <label for="address">Adress</label>
                                <input type="text" name="address" placeholder="Testgatan 43" required style="padding:.5rem;">
                            </div>

                            <div class="" style="display:flex; ">
                                <div class="" style="margin-bottom:1rem; display:flex; flex-direction:column;">
                                    <label for="tel">Telefonnummer</label>
                                    <input type="text" name="tel" placeholder="0700112233" style="padding:.5rem;">
                                </div>

                                <p style="margin:2rem 2rem;">eller</p>

                                <div class="" style="margin-bottom:1rem; display:flex; flex-direction:column;">
                                    <label for="tel">Email</label>
                                    <input type="text" name="email" placeholder="john@doe.com" style="padding:.5rem;">
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="button" class="link" style="margin-top:1rem; border:2px solid rgba(0,0,0,.2); padding:1rem 2rem; background-color:white; font-size:12pt; font-weight:200;">Done</button>
                    </form>


                    {{-- Select pay method --}}
                    <div id="select_pay_method" class="flex-center" style="height:100%;width:100%;">

                        <div class="flex-center" style="flex-direction:column; width:50%; padding:1rem;">
                            <p class="link" style="margin:0; font-size:30pt; font-weight:400;" data-pay-method="card">Kort</p>
                        </div>

                        <div class="flex-center" style="height:40%; flex-direction:column;">
                            <div class="" style="height:50%; width:1px; background-color:rgba(0,0,0,.1)"></div>
                            <h4>eller</h4>
                            <div class="" style="height:50%; width:1px; background-color:rgba(0,0,0,.1)"></div>
                        </div>

                        <div class="flex-center" style="flex-direction:column; width:50%;">
                            <p class="link" style="margin:0; font-size:30pt; font-weight:400;" data-pay-method="swish">Swish</p>
                        </div>

                    </div>
                </div>
            @endif
        </div>

        <div class="" style="width:1px; background-color: rgba(0,0,0,.1); "></div>

        <div style="padding:5rem; width:calc(50% - 10rem); height:80vh; position:relative;">
            @include('modules.cart.full')
        </div>
    </div>
@endsection
