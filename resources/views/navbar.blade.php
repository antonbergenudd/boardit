<div class="navbar">
    <div class="left">
        <a href="{{ url('/') }}" class="link">
            <img src="{{ asset('img/logo.png') }}" alt="Boarditgames logo" class="logo-img">
        </a>
    </div>
    <div class="burger top-right" id="nav-burger">
        <div class="stripe"></div>
        <div class="stripe"></div>
        <div class="stripe"></div>
    </div>
    <div class="links top-right">
        <a href="{{ url('/') }}">Hem</a>
        <a href="{{ route('payment.index') }}">Checkout ({{$cart->count()}})</a>
        <a href="{{ route('games') }}">Spel</a>
        <a href="{{ route('faq') }}">FAQ</a>
        <a href="{{ route('about') }}">Om oss</a>
    </div>

    <div class="navbar-collapsed" id="nav-collapsed">
        <h1 class="navbar-collapsed-title">Boardit</h1>
        <p class="navbar-collapsed-subtitle">Rent it. Board it. Enjoy it.</p>

        <div class="navbar-collapsed-close" id="nav-collapsed-close">
            X
        </div>

        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ url('/') }}">Hem</a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('payment.index') }}">Checkout ({{$cart->count()}})</a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('games') }}">Spel</a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('faq') }}">FAQ</a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('about') }}">Om oss</a>
        <hr class="navbar-collapsed-divider">

    </div>
</div>
