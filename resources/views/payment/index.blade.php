@extends('layouts.default')

@section('content')
    <div style="display:flex; margin-top:4rem;">
        <div class="flex-center" style="@if(Session::get('code')) flex-direction:column; @endif text-align:left; padding:1rem 5rem; width:calc(50% - 10rem);">
            <div class="flex-center" style="height:100%;width:100%; flex-direction:column;" id="pay_method">

                {{-- Display errors --}}
                @if($errors->any())
                    <div class="">
                        @foreach ($errors->all() as $error)
                            <div style="text-align:center;">
                                <h2 style="color:red;">{{ $error }}</h2>
                                <h4>Ingen betalning har utförts!</h4>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Display success --}}
                @if(session()->has('code'))
                    <div class="" style="display:flex; flex-direction:column; width: 25rem;">
                        <h1>Din referens kod är</h1>
                        <h3>{{ Session::get('code') }}</h3>
                        <p>Använd denna kod om du har några funderingar runt din order</p>
                        <p><b>Kontakta oss via</b></p>
                        <p>boarditgames@gmail.com</p>
                        <p>Bekräftelse kommer skickas via sms samt email inom kort.</p>
                        <h2>Tack för att du handlade hos <b>Boardit</b>!</h2>
                    </div>
                @else
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
                @endif

                <form id="payment_form" class="hide" action="{{ route('payment.submit') }}" method="post" style="height:100%; width:100%; min-width:10rem; margin-top:1rem;">
                    {{ csrf_field() }}

                    <input type="hidden" data-env="{{env('STRIPE_TEST_MODE')}}">

                    <div class="hide" data-payment-swish>
                        <div class="" style="text-align:center; margin-bottom:4rem;">
                            <h1>Swish</h1>
                            <h1>1231802255</h1>
                        </div>
                    </div>

                    <h1>Kontakt uppgifter</h1>
                    <div class="" style="display:flex; margin:1rem;">
                        <div class="" style="display:flex; flex-direction:column; width:100%;">
                            <label for="tel">Telefonnummer</label>
                            <input type="text" name="tel" placeholder="0700112233" style="padding:.5rem;">
                        </div>
                    </div>

                    <div style="display:flex; margin:1rem;">
                        <div class="" style="display:flex; flex-direction:column; width:100%;">
                            <label for="tel">Email</label>
                            <input type="text" name="email" placeholder="john@doe.com" style="padding:.5rem;">
                        </div>
                    </div>

                    <h1>Adress</h1>
                    <div style="display:flex; margin:1rem;">
                        <div class="" style="display:flex; flex-direction:column; width:100%;">
                            <label for="address">Gata</label>
                            <input type="text" name="street" placeholder="johndoe 99" required style="padding:.5rem;">
                        </div>
                    </div>

                    <div class="" style="display:flex; margin:1rem;">
                        <div class="" style="display:flex; flex-direction:column; flex:1;">
                            <label for="address">Stad</label>
                            <input type="text" name="city" placeholder="Karlstad" required style="padding:.5rem;">
                        </div>
                        <div class="" style="display:flex; flex-direction:column; flex:1;">
                            <label for="address">Postnummer</label>
                            <input type="number" name="postcode" placeholder="65636" required style="padding:.5rem;">
                        </div>
                    </div>

                    <div class="" style="display:flex; margin:1rem;">
                        <div class="" style="display:flex; flex-direction:column; width:100%;">
                            <label for="note">Till leverans</label>
                            <textarea name="note" rows="4" cols="80" placeholder="Övrigt" style="padding:1rem; flex:1; resize:none; border: 1px solid rgba(0,0,0,.2)"></textarea>
                        </div>
                    </div>

                    <p class="link hide"
                        data-payment-card
                        data-stripe-pay
                        data-stripe-amount="{{$cartTotal}}"
                        style=" width: 3rem; text-align: center; margin-top:1rem; border-radius:0; border:2px solid rgba(0,0,0,.2); margin-left: 1rem; padding:1rem 2rem; background-color:white; font-size:12pt; font-weight:200;">
                        Betala
                    </p>

                    <button
                        data-payment-swish
                        type="submit"
                        class="link hide"
                        style="margin:1rem; border:2px solid rgba(0,0,0,.2); padding:1rem 2rem; background-color:white; font-size:12pt; font-weight:200;">
                        Skickat
                    </button>
                </form>
            </div>
        </div>

        <div class="" style="width:1px; background-color: rgba(0,0,0,.1); "></div>

        <div style="padding:1rem 5rem; width:calc(50% - 10rem); height:80vh; position:relative;">
            @include('modules.cart.full')
        </div>
    </div>
@endsection
