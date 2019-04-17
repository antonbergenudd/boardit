<div class="navbar">
    <div class="left">
        <img class="logo-img" src="{{ asset('img/logo.png') }}" alt="Boarditgames logo">
    </div>
    <div class="links top-right">
        <a href="{{ url('/') }}">Home</a>
        @guest
            {{--  --}}
        @else
            {{ Auth::user()->name }} <span class="caret"></span>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest
    </div>
</div>
