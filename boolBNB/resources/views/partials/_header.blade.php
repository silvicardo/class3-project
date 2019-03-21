<nav class="nav_bar navbar navbar-expand-md navbar-light navbar-laravel">
  <div class="container">
    <div class="nav_bar_left">
      <a href="{{ url('/') }}">
        <img src="{{ asset('img/logo.png') }}" alt="">
      </a>
      <div class="search">
        <div class="search_img">
          <i class="fas fa-search"></i>
        </div>
        <input type="text" placeholder="Cerca" value="">
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of rightNavbar -->
      {{-- <ul class="navbar-nav mr-auto">

      </ul> --}}

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Accedi') }}</a>
          </li>
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Registrati') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Diventa un host') }}</a>
            </li>
            <li class="nav-item">
              <div class="logo_user">
                <img src="{{ asset('img/avatar1.png') }}" alt="">
              </div>

            </li>
          @endif
        @else

          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>


            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

              @if(Auth::user()->hasRole('proprietario'))

              <a class="dropdown-item" href="{{route('owner.profile', Auth::User()->id)}}"
              >
              {{ __('Profilo') }}
              </a>

              <a class="dropdown-item" href="{{route('owner.show', Auth::User()->id)}}"
              >
              {{ __('Appartamenti') }}
              </a>


              @else

              <a class="dropdown-item" href="{{route('guest.profile', Auth::User()->id)}}"
              >
              {{ __('Profilo') }}
              </a>

              <a class="dropdown-item" href="{{route('guest.show', Auth::User()->id)}}"
              >
              {{ __('Dashboard') }}
              </a>


              @endif

              <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
