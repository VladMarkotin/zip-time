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
    <script src="{{ asset('js/backlog/backlog.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @livewireStyles



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    @livewireStyles
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="text-align:center;">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                @if (Route::has('login'))
                    @auth

                        <!-- Button Notification -->
 
                        <div class="btn-group" id="notification_section">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bell" viewBox="0 0 16 16">
                                    <path  @if ($notifications)
                                    style=" animation: bell 4s linear infinite; "
                                    @endif 
                                    d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                                </svg>
                                <span class="badge badge-pill notification--num" @if ($notifications)
                                style="background: #a10000; color:white;  animation: notification 2.2s linear infinite;"
                                @endif > 
 
                                 <span id="main_notification_button" @if (!$notifications) style="color: #BFBABA;"@endif>{{ $count_notifications }}</span></span>

                    
                            </button>
                            <div class="dropdown-menu notifications">
                                @foreach ($notifications as $notification)
                                    <div class="dropdown-item notification"><b>{{ $notification->data }}</b></div>
                                @endforeach
                            </div>
                            <input type="hidden" name="_token" id="_token" value={{ csrf_token() }}>
                        </div>


                 
                    

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addNotification">
                            <span class="mdi mdi-pencil-outline"></span>
                        </button>

                        @if (Auth::user()->role_as == 1)
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#sendToPusher">
                                Отправить через Pusher
                            </button>
                        @endif


                        <!-- Modal Создать уведомление-->
                        <div class="modal fade" id="addNotification" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Create notification</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Notification`s type:</strong>
                                                    <input id="typeNotification" type="text" name="typeNotification"
                                                        class="form-control"
                                                        placeholder='Придумайте тип напоминания (например "Важное")'>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Notification`s text:</strong>
                                                    <input id="dataNotification" type="text" name="dataNotification"
                                                        class="form-control" placeholder="Notification`s text">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Notification`s date:</strong>
                                                    <input id="dateNotification" type="date" name="dateNotification"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                <p></p>
                                                <button id="saveNotification" class="btn btn-light">
                                                   Save
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Отправить через Pusher-->
                        <div class="modal fade" id="sendToPusher" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Отправить через Pusher</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Тип уведомления:</strong>
                                                    <input id="typeNotificationPusher" type="text"
                                                        name="typeNotification" class="form-control" value="Pusher"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Notification`s text:</strong>
                                                    <input id="dataNotificationPusher" type="text"
                                                        name="dataNotification" class="form-control"
                                                        placeholder="Notification`s text">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Notification`s date:</strong>
                                                    <input id="dateNotificationPusher" type="date"
                                                        name="dateNotification" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                <p></p>
                                                <button id="sendNotification" class="btn btn-light">
                                                Send notification
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notification_history') }}">Notifications</a>
                        </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('stat') }}">Statistics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('backlog') }}">Backlog</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span style="color: rgb(94, 155, 94); font-weight: bold">
                                        [ rating: @php
                                            $rating = 
                                                \app\models\User::where('id', Auth::id())
                                                    ->pluck('rating')
                                                    ->first();
                                            
                                            echo $rating;
                                        @endphp ] </span>
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

    <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <script>
        window.addEventListener('message', event => {
            alertify.notify(event.detail.text);
        });
    </script>


    <script>
        ! function(Gleap, t, i) {
            if (!(Gleap = window.Gleap = window.Gleap || []).invoked) {
                for (window.GleapActions = [], Gleap.invoked = !0, Gleap.methods = ["identify", "clearIdentity",
                        "attachCustomData", "setCustomData", "removeCustomData", "clearCustomData", "registerCustomAction",
                        "logEvent", "log", "preFillForm", "sendSilentCrashReport", "startFeedbackFlow", "setAppBuildNumber",
                        "setAppVersionCode", "preFillForm", "setApiUrl", "setFrameUrl", "isOpened", "open", "close", "on",
                        "setLanguage", "setOfflineMode", "initialize"
                    ], Gleap.f = function(e) {
                        return function() {
                            var t = Array.prototype.slice.call(arguments);
                            window.GleapActions.push({
                                e: e,
                                a: t
                            })
                        }
                    }, t = 0; t < Gleap.methods.length; t++) Gleap[i = Gleap.methods[t]] = Gleap.f(i);
                Gleap.load = function() {
                        var t = document.getElementsByTagName("head")[0],
                            i = document.createElement("script");
                        i.type = "text/javascript", i.async = !0, i.src = "https://sdk.gleap.io/latest/index.js", t
                            .appendChild(i)
                    }, Gleap.load(),
                    Gleap.initialize("MMrWTm1w4laW6B2JsT1qPwMxqb1dsyzI")
            }
        }();
    </script>


    {{-- hide backlog modal --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <script type="text/javascript">
        window.livewire.on('userStore', () => {
            $('#exampleModal').modal('hide');
        });
    </script>
    @livewireScripts
    @stack('script')

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        var pusher = new Pusher('20e6273b6c356e483906', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('notifications');
        // Pusher.logToConsole = true;
        channel.bind('App\\Events\\Notifications', function(i) {

            if (i.type == 'Pusher') {

                let token = $('#_token').val();
                let type = i.type;
                let notification_data = i.data;
                let notification_date = i.date;

                $.post('/save_notification', {
                    _token: token,
                    type: type,
                    data: notification_data,
                    notification_date: notification_date
                }, function() {}).done(function(response) {

                })
            }
        });
    </script>


    <script>
        window.addEventListener("load", function() {
            $('body').on('click', '#saveNotification', function() {

                let token = $('#_token').val();
                let type = $('#typeNotification').val();
                let data = $('#dataNotification').val();
                let notification_date = $('#dateNotification').val();

                $.post('/save_notification', {
                    _token: token,
                    type: type,
                    data: data,
                    notification_date: notification_date
                }, function() {}).done(function(response) {
                    $('#addNotification').modal('hide');
                    $("#notification_section").load(" #notification_section");
<<<<<<< Updated upstream
                     alertify.set('notifier','position', 'bottom-right');
                     alertify.notify('Notification Added Successfuly');
=======
                    alertify.set('notifier','position', 'bottom-right');
                    alertify.notify('Notification Added Successfully');
>>>>>>> Stashed changes
                    
                })
            })
        })
    </script>

    {{-- pusher --}}

    <script>
        window.addEventListener("load", function() {
            $('body').on('click', '#sendNotification', function() {
                let token = $('#_token').val();
                let type = $('#typeNotificationPusher').val();
                let data = $('#dataNotificationPusher').val();
                let notification_date = $('#dateNotificationPusher').val();

                $.post('/send_notification', {
                    _token: token,
                    type: type,
                    data: data,
                    notification_date: notification_date
                }, function() {}).done(function(response) {
                    $('#sendToPusher').modal('hide');
                })
            })
        })
    </script>


    <script>
        window.addEventListener("load", function() {
            document.querySelector('.notifications').addEventListener('click', e => {
                let content = e.target.innerHTML;
                e.target.outerHTML = content;
                let token = $('#_token').val();
                $.post('/read_notification', {
                    _token: token,
                    notification_content: content
                }, function() {}).done(function(response) {

                    let message = JSON.parse(response)
                    var text_button_notification = message.count_notifications
                    $('#main_notification_button').text(text_button_notification);

                })
            });
        })
    </script>


    @livewireScripts
</body>

</html>
