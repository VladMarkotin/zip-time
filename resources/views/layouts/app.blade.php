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
    <script src="{{ asset('js/notifications/notifications.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">



    @livewireStyles

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                    <div class="container-fluid" >
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        @if (Route::has('login'))
                        <div class="navbar-nav" id="notification_section">
                            <div class="dropdown" >
                                @if (Auth::check())
                                    
                               
                                <a class="nav-link notification_panel" type="button">
                                  Notifications
                                </a>

                                <svg class="nav-link notification_panel" xmlns="http://www.w3.org/2000/svg"  fill="currentColor"
                                class="bi bi-bell" viewBox="0 0 16 16" >
                                <path                       
                                
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                                </svg>
                                <span class="notification--num" 
                                style="background: red; color:white;"
                                > 
                                <span id="main_notification_button">{{ $count_notifications }}</span></span>

                                {{-- <ul class="dropdown-menu notifications">    
                                  @foreach ($notifications as $notification)
                                  <li><button class="dropdown-item notification" id="{{ $notification->data }}"><b>{{ $notification->data }}</b></button></li>
                         
                                  @endforeach
                                </ul>
                                <input type="hidden" name="_token" id="_token" value={{ csrf_token() }}> --}}
                              </div>
                              
                      <!-- Button trigger modal -->
                            <a style="padding-left:20px" type="button" class="nav-link " aria-current="page" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                 Create Reminder
                            </a>

                            <!-- Button trigger modal -->
                          
                            @if (Auth::user()->role_as == 1)
                            <a type="button"   class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModa2">
                                Pusher Reminder
                            </a>
                    
                        </div>
                        @endif
                        @endif   
                      </div>
                    </div>


              
                    @auth

            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Reminders</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Reminder Type:</strong>
                                                    <input id="typeNotification" type="text" name="typeNotification"
                                                        class="form-control"
                                                        placeholder='Think of a reminder type (for example, "Important")'>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Reminder Text:</strong>
                                                    <input id="dataNotification" type="text" name="dataNotification"
                                                        class="form-control" placeholder="Write the notification text">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Reminder Date:</strong>
                                                    <input id="dateNotification" type="date" name="dateNotification"
                                                        class="form-control">
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                   
                                    <button type="button" id="saveNotification" class="btn btn-danger text-white mx-auto" data-bs-dismiss="modal">Save Reminder</button>
                                    </div>
                                </div>
                                </div>
                            </div>





                            
                          
                            
                            <!-- Modal pusher-->
                            <div class="modal fade" id="exampleModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"> Push Reminder</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <div class="row">

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Reminder Type:</strong>
                                                    <input id="typeNotificationPusher" type="text"
                                                        name="typeNotification" class="form-control" value="Pusher"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Reminder Text:</strong>
                                                    <input id="dataNotificationPusher" type="text"
                                                        name="dataNotification" class="form-control"
                                                        placeholder="Write the notification text">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Reminder Date:</strong>
                                                    <input id="dateNotificationPusher" type="date"
                                                        name="dateNotification" class="form-control">
                                                </div>
                                            </div>

                        
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                  
                                    <button  id="sendNotification" class="btn btn-danger text-white mx-auto" data-bs-dismiss="modal">Send Reminder</button>
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

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <script type="text/javascript">
        window.livewire.on('userStore', () => {
            $('#exampleModal').modal('hide');
        });
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


    @livewireScripts
</body>

</html>
