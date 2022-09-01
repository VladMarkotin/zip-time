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


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            @if (Route::has('login'))
                @auth
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" id="main_notification_button" data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            Уведомления ( {{$count_notifications}} )
                        </button>
                        <div class="dropdown-menu notifications">
                            {{--                            <div class="dropdown-divider"></div>--}}
                            {{--                            <a class="dropdown-item" href="#">Separated link</a>--}}
                        </div>
                        <input type="hidden" name="_token" id="_token" value={{ csrf_token() }}>
                        {{--                        <button class="btn btn-warning" id="send_notification">Отправить</button>--}}
                    </div>
                @endauth
            @endif

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

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
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
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
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')

    </main>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


<script type="text/javascript">
    window.livewire.on('userStore', () => {
        $('#exampleModal').modal('hide');
    });
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script type="text/javascript">

    var pusher = new Pusher('20e6273b6c356e483906', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('notifications');
    // Pusher.logToConsole = true;
    channel.bind('App\\Events\\Notifications', function (data) {

        $('.notifications').append('<div class="dropdown-item notification">' + data.data + '</div>')

    });

</script>

<script>
    window.addEventListener("load", function () {
        let token = $('#_token').val();
        $.post('/send_notification', {_token: token}, function () {
        }).done(function (response) {

        })
    })
</script>

<script>
    window.addEventListener("load", function () {
        document.querySelector('.notifications').addEventListener('click', e => {
            let content = e.target.innerHTML;
            let token = $('#_token').val();
            // alert(content);
            $.post('/read_notification', {_token: token, notification_content: content}, function () {
            }).done(function (response) {

                let message = JSON.parse(response)

                var text_button_notification = "Уведомления ( " + message.count_notifications + " ) ";
                $('#main_notification_button').text(text_button_notification);

            })
        });
    })
</script>


{{--<script>--}}
{{--    window.addEventListener("load", function () {--}}
{{--        $('body').on('click', '#send_notification', function () {--}}
{{--            let token = $('#_token').val();--}}
{{--            $.post('/send_notification', {_token: token}, function () {--}}
{{--            }).done(function (response) {--}}

{{--            })--}}
{{--        })--}}
{{--    })--}}
{{--</script>--}}

@livewireScripts

</body>
</html>
