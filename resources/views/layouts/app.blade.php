<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="js/indexPage.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" src='https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.0.1/introjs.min.css'>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/indexPage/indexPage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/indexPage/indexPageMedia.css') }}" rel="stylesheet">
    @livewireStyles



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <livewire:styles />
</head>

<body>

    <livewire:feedback />
    <livewire:dropdown />
    <livewire:add-log />

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm nav-menu">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="text-align:center;">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto ">

                        @if (Route::has('login'))
                            @auth
                                <!-- Button Notification -->

                                <div class="btn-group">
                                    <button type="button" class="btn btn-light " id="bell">
                                        <livewire:counter />
                                    </button>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-light " data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <span class="mdi mdi-pencil-outline"></span>
                                    </button>

                                    @if (Auth::user()->role_as == 1)
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal2">
                                            <b> <i class="bi bi-broadcast-pin"></i> Broadcast</b>
                                        </button>
                                    @endif
                                </div>
                            @endauth
                        @endif

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('stat') }}">Statistics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('hist') }}">History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('backlog') }}">Backlog</a>
                            </li>
                            <li class="nav-item dropdown personal-results-toggle">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    <span id="total-results">
                                            {{ Auth::user()->rating  }}                                    
                                    </span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>

                                <div class="personal-results">
                                    <personal-results />
                                </div>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-0">

            @yield('content')
        </main>

    </div>
    <livewire:scripts />
    @stack('script')




    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="footer">
    <div class="footer-info">
        <p class="footer-text">
            footer text Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Aliquet eget sit amet tellus cras
            adipiscing.
        </p>
        <p class="footer-text">© 2023</p>
    </div>
</footer>

</html>
