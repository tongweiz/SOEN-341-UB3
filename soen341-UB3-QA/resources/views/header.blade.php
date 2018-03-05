<!DOCTYPE html>
<html lang="en">

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">

        <a href="{{ route('welcome') }}"> <img src="{{asset('assets/jux_logo.png')}}"> </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('welcome') }}" style="font-size: 20px">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links ">
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">

                        <ul class="nav navbar-nav navbar-right">

                            @guest
                                <a class="nav-link" style="font-size: 20px" href="{{ route('login') }}">Login</a>
                                <a class="nav-link" style="font-size: 20px" href="{{ route('register') }}">Register</a>

                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                                       aria-expanded="false" aria-haspopup="true" style="font-size: 20px">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li><a style="color: #212529; font-size: 20px; padding: 10px;"
                                               href="{{ route('profile') }}" class="dropdown-item"> Profile </a></li>
                                        <li>
                                            <a style="color: #212529; padding: 10px; font-size: 20px;"
                                               href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                               class="dropdown-item">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest

                        </ul>
                    </div>
                </div>
            @endif
        </div>

    </div>
</nav>

</body>
</html>
