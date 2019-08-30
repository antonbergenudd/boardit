@extends('layouts.default')

@section('content')
    <div class="payment">
        <div class="payment-left flex-center" style="@if(Session::get('code')) flex-direction:column; @endif">
            <div class="pay-method flex-center" id="pay_method">

                {{-- Display errors --}}
                {{-- @if($errors->any())
                    <div class="errors">
                        @foreach ($errors->all() as $error)
                            <div class="errors-wrapper">
                                <h2>{{ $error }}</h2>
                                <h4>Ingen betalning har utförts!</h4>
                            </div>
                        @endforeach
                    </div>
                @endif --}}

                {{-- Display success --}}
                @if(session()->has('code'))
                    <div class="payment-code">
                        <div class="" style="text-align:center;">
                            <i class="material-icons" style="font-size:50pt; color:#90EE90;">check_circle</i>
                            <h4 style="margin:0;">referenskod</h4>
                            <h2 style="margin-top:0;">{{ Session::get('code') }}</h2>
                        </div>

                        <p style="margin:0;">Använd denna kod om du har några funderingar runt din order. <br> Bekräftelse kommer skickas via sms samt email inom kort.</p>

                        <h2 style="margin-bottom:.5rem;">Har du inte beställt upphämtning?</h2>
                        <p style="margin:0;">Återlämning sker inom 24 timmar efter det att du fått spelet.</p>
                        <p style="margin:0;">Adress för återlämning: <b>Vikingavägen 16b, 224 77, Lund</b></p>.
                        <br>
                        <br>
                        <h2>Tack för att du handlade hos på <b>Boardit</b>!</h2>
                    </div>
                @else
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

                        <div class="payment-select-swish flex-center">
                            <p class="link" data-pay-method="swish">Swish</p>
                        </div>

                    </div>
                @endif

                <form class="payment-form hide" id="payment_form" action="{{ route('payment.submit') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" data-env="{{env('STRIPE_TEST_MODE')}}">

                    <div class="payment-form-header hide" data-payment-swish>
                        <h1>Swish</h1>
                        <h1>1231802255</h1>
                    </div>

                    <h2>Kontakt uppgifter</h2>
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

                    <h2>Adress</h2>
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

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="note">Övriga anteckningar</label>
                            <textarea name="note" rows="4" cols="80" placeholder="Text här.."></textarea>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="user_consent">
                                <input name="user_consent" type="checkbox" data-validate-checkbox>
                                Läs igenom och godkänn våran användar <a class="link" href="{{ route('policy') }}">policy</a> innan du betalar!
                            </label>
                        </div>
                    </div>

                    <div class="actions" data-validate-submit>
                        @if($cartTotal > 0)
                        <p class="payment-form-submit-card link hide"
                            data-payment-card
                            @if($cartTotal > 0)
                                data-stripe-pay
                                data-stripe-amount="{{ $cartTotal + 30 }}"
                            @endif
                            >
                            Betala
                        </p>

                        <button
                            data-payment-swish
                            @if($cartTotal > 0)
                                type="submit"
                            @endif
                            class="payment-form-submit-swish link hide"
                            >
                            Swish utfört
                        </button>
                        @else
                            <h4>Kundvagnen är tom</h4>
                        @endif
                    </div>
                </form>
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
