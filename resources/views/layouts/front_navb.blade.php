<nav class="navbar navbar-expand-lg bg-dark navbar-light">
    <div class="container"><a class="navbar-brand text-white" href="{{route('front-page')}}">DG</a><button data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"></li>
                <li class="nav-item"></li>
                <li class="nav-item dropdown">
                    <ul aria-labelledby="navbarDropdown" class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item"></li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link fs-5 text-white" href="{{route('front-page')}}">Home</a></li>

                @guest
                <li class="nav-item fs-5"><a class="nav-link text-white" href="{{route('home')}}">Login</a></li>
                @if (Route::has('register'))
                        <li class="nav-item fs-5"><a class="nav-link text-white" href="{{route('home')}}">Register</a></li>
                @endif
                @endguest


                @auth
                    <li class="nav-item"><a class="nav-link fs-5 text-white" href="{{route('dashboard')}}">Dashboard</a></li>
                    <a class="nav-link fs-5 text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth

            </ul>
        </div>
    </div>
</nav>
