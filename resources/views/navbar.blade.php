<div class="navbar">
    <div class="left">
        <a href="{{ url('/') }}" class="link">
            <img src="{{ asset('img/logo.png') }}" alt="" style="width:5rem; padding:1rem;">
        </a>
    </div>
    <div class="links top-right">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('payment.index') }}">Checkout ({{$cart->count()}})</a>
        <a href="{{ route('games') }}">Spel</a>
        <a href="{{ route('about') }}">Om oss</a>
    </div>
</div>
