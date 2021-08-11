<div class="navbar" style="background-color:none;">
    <div class="logo flex-center">
        <a href="/" class="logo-wrapper">
            <div class="logo-img-wrapper">
                <img src="{{ asset('images/logos/logo_white.png') }}" alt="Boardit logo">
            </div>
        </a>
    </div>
    <div class="links flex-center">
        <a href="{{ route('assortment') }}" class="{{ (request()->is('sortiment')) ? 'active-link' : '' }}">sortiment</a>

        <a href="#"><i class="fa fa-search"></i></a>
        <a href="#"><i class="fa fa-shopping-cart"></i></a>
        {{-- <div class="dropdown">
            <a class="dropbtn {{ (request()->is('student*')) ? 'active-link' : '' }}">Student</a>
            <div class="dropdown-content">
                <a href="{{ route('student.new') }}">Ny student</a>
                <a href="{{ route('student.songs') }}">Sånger</a>
                <a href="{{ route('student.associations') }}">Föreningar</a>
            </div>
        </div> --}}
    </div>
</div>
