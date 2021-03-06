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
        <a href="{{ route('games') }}">Spel</a>
        <a id="navbar-checkout" class="link" href="{{ route('payment.index') }}">
            Beställ 
            <div class="link-cart-count @if($cart_qty == 0) hide @endif">
                <span data-cart-count>{{$cart_qty}}</span>
            </div>
        </a>
        
        {{-- <a href="{{ route('faq') }}">FAQ</a> --}}
        {{-- <a href="{{ route('about') }}">Om oss</a> --}}
        @if(Auth::check())
            <a href="{{ route('auth.orders') }}"><b>Orders</b></a>
        @endif
    </div>

    <div class="navbar-collapsed" id="nav-collapsed">
        <div class="navbar-collapsed-header">
            <h1 class="navbar-collapsed-title">Boardit</h1>
            <p class="navbar-collapsed-subtitle">Rent it. Board it. Enjoy it.</p>
        </div>

        <div class="navbar-collapsed-close" id="nav-collapsed-close">
            <i class="material-icons">arrow_forward</i>
        </div>

        {{-- collapsed links --}}
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ url('/') }}">Hem</a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('payment.index') }}">Beställ <div class="link-cart-count"><span data-cart-count>{{$cart_qty}}</span></div></a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('games') }}">Spel</a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('faq') }}">FAQ</a>
        <hr class="navbar-collapsed-divider">
        <a class="navbar-collapsed-link" href="{{ route('about') }}">Om oss</a>
        @if(Auth::check())
            <hr class="navbar-collapsed-divider">
            <a class="navbar-collapsed-link" href="{{ route('auth.orders') }}">Orders (auth)</a>
        @endif
        <hr class="navbar-collapsed-divider">

    </div>
</div>
