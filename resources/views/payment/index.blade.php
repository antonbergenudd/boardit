@extends('layouts.default')

@section('content')
    <div class="payment">
        <div class="payment-left flex-center" style="@if(Session::get('code')) flex-direction:column; @endif">
            <div class="pay-method flex-center" id="pay_method">

                {{-- Display errors --}}
                @if($errors->any())
                    <div class="errors">
                        @foreach ($errors->all() as $error)
                            <div class="errors-wrapper">
                                <h2>{{ $error }}</h2>
                                <h4>Ingen betalning har utförts!</h4>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Display success --}}
                @if(session()->has('code'))
                    <div class="payment-code">
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

                    <h1>Kontakt uppgifter</h1>
                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="tel">Telefonnummer</label>
                            <input type="text" name="tel" placeholder="0700112233">
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="tel">Email</label>
                            <input type="text" name="email" placeholder="john@doe.com">
                        </div>
                    </div>

                    <h1>Adress</h1>
                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="address">Gata</label>
                            <input type="text" name="street" placeholder="johndoe 99" required>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="address">Stad</label>
                            <input type="text" name="city" placeholder="Karlstad" required>
                        </div>
                        <div class="input-box-wrapper">
                            <label for="address">Postnummer</label>
                            <input type="number" name="postcode" placeholder="65636" required>
                        </div>
                    </div>

                    <div class="payment-form-input-box">
                        <div class="input-box-wrapper">
                            <label for="note">Till leverans</label>
                            <textarea name="note" rows="4" cols="80" placeholder="Övrigt"></textarea>
                        </div>
                    </div>

                    <p>Läs igenom våran användar <a class="link" href="{{ route('policy') }}">policy</a> innan du betalar!</p>

                    <div class="actions">
                        <p class="payment-form-submit-card link hide"
                            data-payment-card
                            data-stripe-pay
                            data-stripe-amount="{{$cartTotal}}"
                            >
                            Betala
                        </p>

                        <button
                            data-payment-swish
                            type="submit"
                            class="payment-form-submit-swish link hide"
                            >
                            Skickat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="payment-divider"></div>

        <div class="payment-right">
            @include('modules.cart.full')
        </div>
    </div>
@endsection
