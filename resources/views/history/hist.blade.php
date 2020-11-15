@extends('layouts.app')

<div class="content">
@section ("hist_cards")

<div class="row justify-content-center">
    @if($histDayPlan)

            <div class="col-sm-6">
              <div class="cards-content">
                <div class="card">
                  <div class="card-header">
                    Дата:{{ $histDayPlan[0]->date  }} | Статус: {{$histDayPlan[0]->day_status}}
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"></h5>
                    <table class="table">
                    <tr>
                        <th>Задание</th>
                        <th>Статус</th>
                        <th>Время</th>
                        <th>Оценка</th>
                        <th>Детали</th>
                        <th>Заметки</th>
                    </tr>
                        @foreach($histDayPlan as $k => $v)
                        <tr>
                        <td><p class="card-text">{{ $v->task_name }}</p></td>
                        <td><p class="card-text">{{ ($v->status == 2) ? "Обязательное": ($v->status == 1 ? "Необязательное": "Задача") }}</p> </td>
                        <td>{{ $v->time }}</td>
                        <td>

                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon1">{{ $v->mark }}%</span>
                            </div>
                        </td>
                        <td>{{ $v->details }}</td>
                        <td>{{ ($v->note !== "null") ? $v->note: '' }}</td>
                        </tr>
                        @endforeach
                    </table>
                    <hr/>
                    <p class="text-bold text-left">Итого: <span class="text-center"> {{$histDayPlan[0]->time_of_day_plan}} часов </span></p>
                    <p class="text-bold text-left">КПД: {{ $histDayPlan[0]->final_estimation > -1 ?  $histDayPlan[0]
                        ->final_estimation." %"  : "-"}} | {{  $histDayPlan[0]->own_estimation != -1 ? $histDayPlan[0]->own_estimation: ''}}% </p>
                   </div>
                  </div>
               </div>
            </div>
    @endif
</div>
@endsection
</div>