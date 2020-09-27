@extends('layouts.app')

@if($plan == [])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     {{$message}} <a href="/" class="text-primary">Составить план</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@else
@section('list')
<div class="container">
<!-- Добавить задание -->
    <div class="row justify-content-center">
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                                                   id="modal-content"
                                                                                   aria-hidden="true" >
                     <div class="modal-dialog modal-lg" >
                         <div class="modal-content" id="modal-content">
                            <h3 id="h3" style="text-align: center">Добавление задания:</h3>
                            <hr/>
                            <div class="text-center" id="newTask">
                            <form method='post' id='newTaskForm' action=''>

                                    <hr/>
                                    <div class='list-inline'>

                                                <input id="short" type='text' title='Короткое название задания' size='32' placeholder='Короткое название задания'>
                                                <input id="time" type='time' title='Примерное время выполнения' placeholder='Примерное время выполнения'>
                                                <input id="note" type='text' title='Примечания' placeholder='Примечания'>
                                                <select class='custom-select-sm' id="status">
                                                <option>Обязательное задание</option>
                                                <option>Необязательное задание</option>
                                                <option>Задача</option>
                                                </select>

                                    </div>
                                <hr/>
                                <button type="button" onclick="save()" class="btn btn-primary">
                                    Сохранить
                                </button>

                            </form>

                            </div>
                           </div>
                     </div>
                     </div>

                      <h3>Расписание на день</h3>

                    </div>
<!-- Конец -->

<!-- Экстренный режим -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                                                   aria-hidden="true"
                                                                                    id="emergencyCall">
     <div class="modal-dialog modal-lg" >
         <div class="modal-content" id="emergency-content">
             <h3 id="h3" style="text-align: center">Запрос на экстренный режим:</h3>
             <span id="emergencyInfo" style="text-align: center"></span>
              <hr/>
              <div class="text-center" id="emergencyCall">
                 <form method='post' id='emergencyForm' action=''>
                      <hr/>
                      <div class='list-inline'>
                        <p class="text-info">Укажите причину активации экстренного режима</p>

                        <div class="form-group" style="margin-left: 22% ">
                          <textarea class="form-control" id="emergencyTextarea" rows="3" style="width: 70%;" ></textarea>
                        </div>

                      </div>
                      <hr/>
                      <button type="button" onclick="emergencyRequest()" class="btn btn-danger">
                          Включить экстренный режим
                      </button>
                  </form>
              </div>
         </div>
 </div>
 </div>
<!-- Конец -->
        <div class="col-md-8">
            <div class="card" style="width: 150%;">
                <div class="card-header">План на {{$date}}</div>
                <div id="info"></div>
                <div class="card-body">
                    <p>Статус: {{ $day_status }}</p>
                    <table class="table table-bordered table-hover">
                    <thead>
                                    <tr>
                                      <th scope="col">Задание</th>
                                      <th scope="col">Детали</th>
                                      <th scope="col">Время</th>
                                      <th scope="col">Статус задания</th>
                                      <th scope="col">Оценка</th>
                                      <th scope="col">Заметки</th>
                                    </tr>
                                  </thead>
                        @foreach($plan as $p)

                                  <tbody>
                                    <tr>
                                      <td>{{ $p->task_name }}</td>
                                      <td>{{ $p->details }}</td>
                                      <td>{{ $p->time }} часа</td>
                                      @switch($p->status)
                                          @case('2')
                                              <td> Обязательное </td>
                                              @break

                                          @case('1')
                                              <td> Необязательное </td>
                                              @break

                                          @case('0')
                                               <td> Задача </td>
                                               @break

                                          @default
                                              <span>Something went wrong, please try again</span>
                                      @endswitch
                                      <td width="300">

                                      @if($p->status == '2' || $p->status == '1')
                                              @if( !$p->mark)
                                              <div class="input-group mb-3 ">
                                                 <input class="form-control" type="number" id="{{$p->task_id}}"
                                                           min="50" max="100"
                                                             aria-describedby="basic-addon1"
                                                               data-bind="value:replyNumber"
                                                                 aria-label="Оценка"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon1">%</span>
                                                       </div>
                                                 </div>
                                                 @else
                                                     <div class="input-group mb-3 ">
                                                        <input class="form-control" type="number" id="{{$p->task_id}}"
                                                             min="50" max="100"
                                                             value="{{ $p->mark }}"
                                                               aria-describedby="basic-addon1"
                                                                  data-bind="value:replyNumber"
                                                                    aria-label="Оценка"/>
                                                                       <div class="input-group-append">
                                                                           <span class="input-group-text" id="basic-addon1">%</span>
                                                                       </div>
                                                     </div>
                                                     @endif
                                      @else
                                            <div class="input-group mb-3 ">
                                               <input class="form-control" type="checkbox" id="{{$p->task_id}}"
                                                     aria-describedby="basic-addon1"
                                                     data-bind="value:replyNumber"
                                                     aria-label="Оценка"
                                                     @if($p->mark == 99) checked @endif/>
                                               <div class="input-group-append">
                                                  <span class="input-group-text" id="basic-addon1">?</span>
                                               </div>
                                            </div>
                                      @endif
                                           </td>

                                           <td width="300px">
                                           @if( $p->note == 'NULL' )
                                               <div class="input-group mb-3">

                                                     <input type="text" class="form-control" placeholder="Заметки"
                                                        aria-label="Username"
                                                            aria-describedby="basic-addon2"
                                                                >

                                                      <div class="input-group-prepend">
                                                           <span class="input-group-text" id="basic-addon2">А</span>
                                                      </div>
                                                   </div>
                                           @else
                                                   <div class="input-group mb-3">

                                                       <input type="text" class="form-control" placeholder="Заметки"
                                                              aria-label="Username"
                                                                  aria-describedby="basic-addon2"
                                                                     value="{{$p->note}}"
                                                       >
                                                    <div class="input-group-prepend">
                                                       <span class="input-group-text" id="basic-addon2">А</span>
                                                    </div>

                                                </div>
                                        @endif
                                        <input type="hidden" value="{{ $p->task_id }}">
                                      </td>
                                        </tr>
                                  </tbody>
                                  @endforeach

                                </table>
                                <div class="list">
                                  <div class="list-group">
                                     <div class="list-group-item ">
                                        <p class="text-info">Итого:</p>
                                     </div>
                                     <div class="list-group-item ">
                                        <p class="text-info">КПД:</p>
                                     </div>
                                     <div class="list-group-item ">
                                         <p class="text-info">Комментарий: <span class="text-dark">{{ $comment }} </span></p>
                                         <p class="text-info">Необходимо: </p>
                                         <p class="text-info">На завтра:</p>
                                     </div>
                                  </div>
                              </div>

                              <div class="list-inline">
                                    <div class="list-group">
                                        <div class="list-group-item ">
                                            <div class="text-center">
                                                <button type="button" id="emergency" class="btn btn-danger"
                                                     data-toggle="modal"
                                                        data-target="#emergencyCall">
                                                    Экстренный режим
                                                </button>
                                                <button type="button" class="btn btn-success">Утвердить</button>
                                                <button type="button" class="btn btn-primary"
                                                    data-toggle="modal"
                                                     data-target="#modal-content">
                                                        Добавить задание
                                                    </button>
                                            </div>
                                        </div>
                                      </div>
                              </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Тест -->
            <script src="{{ asset('js/Timetable/addTask.js') }}"></script>
 <!-- Конец -->
@endsection
@endif
