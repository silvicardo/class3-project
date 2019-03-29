
<nav class="nav_bar navbar navbar-expand-md navbar-light navbar-laravel">
  <div class="container">
    <div class="nav_bar_left">
      <a href="{{ url('/') }}">
        <img src="{{ asset('img/logo.png') }}" alt="">
      </a>
      {{-- controlliamo la rotta per non far proprio arrivare in pagina --}}
      @if($nomePaginaCorrente !== 'search')
        <form id="navbar_search" action="{{route('search')}}" class="search" method="POST">
          @csrf
          @method('POST')
          <div class="search_img">
            <i class="fas fa-search"></i>
          </div>
          <input id="campo_citta" type="text" name="citta_cercata" placeholder="Cerca città" value="">
        </form>
      @endif

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
          @endif

        @else

          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>


            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

              @if(Auth::user()->hasRole('owner'))

              <a class="dropdown-item" href="{{route('owner.profile', Auth::User()->id)}}"
              >
              {{ __('Profilo') }}
              </a>

              <a class="dropdown-item" href="{{route('owner.show', Auth::User()->id)}}"
              >
              {{ __('I tuoi appartamenti') }}
              </a>

              <a class="dropdown-item" href="{{route('owner.sponsor.create')}}"
              >
              {{ __('Sponsorizzazioni') }}
              </a>


              @else

              <a class="dropdown-item" href="{{route('guest.profile', Auth::User()->id)}}"
              >
              {{ __('Profilo') }}
              </a>

              <a class="dropdown-item" href="{{route('guest.show', Auth::User()->id)}}"
              >
              {{ __('Le tue prenotazioni') }}
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

          @if(Auth::user()->hasRole('owner'))

            <a href="{{route('owner.profile', Auth::User()->id) }}">
              <li class="nav-item">
                <div class="logo_user">
                  <img src="{{ asset('storage/' . Auth::user()->image_profile) }}" alt="">
                </div>
              </li>
            </a>
          @else
            <a href="{{route('guest.profile', Auth::User()->id) }}">
              <li class="nav-item">
                <div class="logo_user">
                  <img src="{{ asset('storage/' . Auth::user()->image_profile) }}" alt="">
                </div>
              </li>
            </a>
          @endif
        @endguest


      </ul>
    </div>
  </div>
</nav>
