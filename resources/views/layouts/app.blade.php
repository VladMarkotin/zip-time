<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script
      src="https://code.jquery.com/jquery-3.5.1.js"
      integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
      crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/estimation/estimation.js') }}"></script>
    <script src="{{ asset('js/emergency/emergency.js') }}"></script>
    <script src="{{asset('js/auth/tables.js')}}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h2>{{ config('app.name', 'Laravel') }}</h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <div class="container justify-content-center" style="margin-right:10%">
                        <ul class="navbar-nav ">

                            <li class="nav-item">
                              <a class="nav-link" href="/">План на квартал</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/">План на неделю</a>
                            </li>
                            <li class="nav-item">
                                <b><a class="nav-link" href="/" style="color:#fca311;">Лента</a></b>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('stat') }}">Статистика</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hist') }}" class="nav-link">История</a>
                             </li>
                        </ul>
                    </div>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>


                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('profile')}}">Профиль</a>
                                    <a class="dropdown-item" href="/">Настройки</a>
                                    <a class="dropdown-item" href="/">Правила</a>
                                    <hr/>
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
                            {{--<li class="nav-item dropdown">iupoh</li>--}}
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            @yield('list');
            @yield('vacation')
            <div class="container-fluid">
                @yield('history.sorts.sorts')
                @yield('hist_cards')
                @yield('stat_cards')
                @yield('profile')
            </div>
        </main>
    </div>


</body>
</html>
