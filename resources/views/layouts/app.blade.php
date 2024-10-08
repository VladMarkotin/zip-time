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
    {{-- костыль, что бы замаскировать дергание страницы при загрузке --}}
    <script src="{{ asset('js/PageSmoothAppear.js') }}" defer></script>
    @if(Route::currentRouteName() == 'settings')
        <script src="{{ asset('js/SettingsPageController.js')}}" defer></script>
    @endif
    @guest
        @if (Route::currentRouteName() == 'welcome')
            <script src="{{ asset('js/IndexPageController.js') }}" defer></script>
        @endif
    @endguest
    <script src="{{ asset('js/NavMenu.js') }}" defer></script>
    <script src="{{ asset('js/AsideButtonsController.js') }}" defer></script>
    {{--  --}}
 

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" src='https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.0.1/introjs.min.css'>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk:wght@400;500;600&display=swap"
        rel="stylesheet">
    @guest
        @if (Route::currentRouteName() == 'welcome')
            <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
        @endif
        @if (Route::currentRouteName() == 'login')
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        @endif
    @endguest
    @if (Route::currentRouteName() == 'settings')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
            rel="stylesheet">
    @endif
    @if(Route::currentRouteName() == 'backlog')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    @endif
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @guest
        @if (Route::currentRouteName() == 'welcome')
            <link href="{{ asset('css/indexPage/indexPage.css') }}" rel="stylesheet">
            <link href="{{ asset('css/indexPage/indexPageMedia.css') }}" rel="stylesheet">
        @endif
        @if(Route::currentRouteName() == 'backlog')
            <link href="{{ asset('css/backlogPage/backlogPage.css') }}" rel="stylesheet">
            <link href="{{ asset('css/backlogPage/backlogMedia.css') }}" rel="stylesheet">
        @endif
    @endguest
    @if (Route::currentRouteName() == 'settings')
        <link href="{{ asset('css/settingsPage/settingsPage.css') }}" rel="stylesheet">
        <link href="{{ asset('css/settingsPage/settingsPageMedia.css') }}" rel="stylesheet">
    @endif
    @if(Route::currentRouteName() == 'backlog')
        <link href="{{ asset('css/backlogPage/backlogPage.css') }}" rel="stylesheet">
        <link href="{{ asset('css/backlogPage/backlogMedia.css') }}" rel="stylesheet">
    @endif
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
    @include('preloader')
    <livewire:feedback />
    <livewire:dropdown />
    <livewire:add-log />
    <div id="app" class="root" style="transition: .5s opacity">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm nav-menu">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="text-align:center;">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}" style="color: #fff;">
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
                    <ul class="navbar-nav ml-auto align-items-center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
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
                                    <div class="navbar-user-name">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <span id="total-results">
                                        {{ Auth::user()->rating }}
                                    </span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
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


        <main class="py-0 main">

            @yield('content')
        </main>

        <div class="aside-buttons-activator-wrapper">
            <span class="aside-buttons-activator"></span>
        </div>

        <footer class="footer">
            <div class="container footer-container">
                <div class="footer-top">
                    <div class="footer-top_brand">
                        <a href="{{ url('/') }}" class="footer-link">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <ul class="footer-top_slogan-list">
                        <li class="footer-top_slogan-li">Fast planning</li>
                        <li class="footer-top_slogan-li">Full execution</li>
                        <li class="footer-top_slogan-li">Enjoying results</li>
                    </ul>
                </div>
            </div>
            <div class="footer-border"></div>
            <div class="container footer-container">
                <div class="footer-bottom">
                    <div class="footer-bottom_info"> 
                        <div class="footer-bottom_main-info">
                            <span>{{ config('app.name', 'Laravel')}}</span>  
                            &copy
                            <span class="footer-bottom_main-info-year">{{now()->year}}</span>
                        </div>
                        <div class="footer-bottom-mail">
                            <a href="mailto:support@quipl.co">Contact us</a>
                        </div>
                    </div>
                    <ul class="footer-bottom_list">
                        @guest
                            <li class="footer-list-li">
                                <a class="footer-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endguest
                        @auth
                            <li class="footer-list-li">
                                <a class="footer-link" href="{{ route('stat') }}">Statistics</a>
                            </li>
                            <li class="footer-list-li">
                                <a class="footer-link" href="{{ route('hist') }}">History</a>
                            </li>
                            <li class="footer-list-li">
                                <a class="footer-link" href="{{ route('backlog') }}">Backlog</a>
                            </li>
                        @endauth
                        <li class="footer-list-li">
                            <a class="footer-link" href="{{ route('privacy.index') }}">Privacy Policy</a>
                        </li>
                        <li class="footer-list-li">
                            <a class="footer-link" href="{{ route('termsofuse.index') }}">Terms of Use</a>
                        </li>
                        <li class="footer-list-li">
                            <a class="footer-link" href="{{ route('dataDeletionPolicy.index') }}">Data Deletion Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    <livewire:scripts />
    @stack('script')




    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @auth
        <script>
          
            askForPermission()
            navigator.serviceWorker.register("{{ URL::asset('service-worker.js') }}");

            function askForPermission() {

                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        // get service worker
                        navigator.serviceWorker.ready.then((sw) => {
                            // subscribe
                            sw.pushManager.subscribe({
                                userVisibleOnly: true,
                                applicationServerKey: "BGPbvN2N_ETuxiZZ90jMjXWardKtcrhDeFr93npJg5pInkDpDtJfUXRH0Het53h-zNUgRmS30N9iiCM-uN6Jsxk"
                            }).then((subscription) => {
                                console.log((subscription));
                                saveSub(JSON.stringify(subscription));
                            });
                        });
                    }
                });
            }

            function saveSub(sub) {

                $.ajax({
                    type: 'post',
                    url: '{{ URL('save-push-notification-sub') }}',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'sub': sub
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            }
        </script>
    @endauth
</body>

</html>
