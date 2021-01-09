<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Tm</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="{{ asset('/css/auth/main.css') }}" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>


        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .carousel-control-next{
            background: #aeaeae;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Tm</a>
                    @else
                        <a href="{{ route('login') }}">Вход</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Регистрация</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">



                <div class="title m-b-md">
                    Tm - просто контролируй время!
                </div>

                <!-- Tab links -->
                <div class="tab">
                  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">План на день</button>
                  <button class="tablinks" onclick="openCity(event, 'Paris')">План на неделю</button>
                  <button class="tablinks" onclick="openCity(event, 'Tokyo')">План на квартал</button>
                </div>

                <!-- Tab content -->
                <div id="London" class="tabcontent">
                <div id="info"></div>

                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                                               aria-hidden="true" >
                 <div class="modal-dialog modal-lg" >
                 <div class="modal-content" id="modal-content">
                    <h3 >Формирование списка заданий:</h3>
                    <hr/>

                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="carousel-item active">
                                <label for="status">Выберите текущий статус дня: </label>
                                   <select class="dropdown" id="status">
                                    <option> Ред </option>
                                    @if($isWeekendAble)
                                        <option>Вых</option>
                                     @else
                                        <option disabled>Вых</option>
                                    @endif
                                    <option> Празд   </option>
                                    @if($isVacationAble)
                                    <option> Отпуск  </option>
                                    @else
                                    <option disabled> Отпуск  </option>
                                    @endif
                                    <option> Экстрен </option>
                                </select>
                            </div>
                            <div class="carousel-item">
                                <p id="dayStatus"></p>
                                <button class="btn btn-primary" id="addRequiredTask">Добавить обязательное задание</button>
                                <div id="list"></div>
                            </div>
                            <div class="carousel-item">
                                <button class="btn btn-info" id="addNonRequieredTask">
                                    Добавить необязательное задание
                                </button>
                                <div id="list2"></div>
                                </div>

                             <div class="carousel-item">
                             <div class="card mt-4">
                                        <div class="py-4 card-body">
                                            <h2>Example component</h2>
                                            <ExampleComponent></ExampleComponent>
                                        </div>
                                    </div>
                                    <input type="hidden" name="jsonResult" id="jsonResult">
                                    <button class='btn btn-info' id='save' type="submit">Сохранить</button>
                             </div>
                             </div>
                          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>

                        </div>

                    </div>
                 </div>
                 </div>

                  <h3>Расписание на день</h3>
                  <p>Здесь будут отображаться все задания на день</p>
                  <button class="btn btn-primary" id="createTimetable" data-toggle="modal" data-target=".bd-example-modal-lg">
                    Сформировать расписание на день
                  </button>

                </div>

                <div id="Paris" class="tabcontent">
                  <h3>Размышления</h3>
                  <p>Здесь просто важные мысли </p>
                </div>

                <div id="Tokyo" class="tabcontent">
                  <h3>История</h3>
                  <p>А здесь история..</p>
                </div>
            </div>
        </div>
        <script
                  src="https://code.jquery.com/jquery-3.5.0.min.js"
                  integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
                  crossorigin="anonymous"></script>
        <script src="{{ asset('/js/Timetable/test.js') }}"></script>
        <script src="{{ asset('/js/auth/tables.js') }}"></script>
        <script type="text/javascript">
          $(document).ready(function() {
            $('.carousel').carousel({
              interval: false
            })
          });
        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


        <script type="text/javascript">
                var token = '{{ csrf_token() }}';
        </script>
    </body>
</html>
