@extends('layouts.app')

<div class="content">
@section ("stat_cards")

<div class="center"> <!-- row justify-content-center-->

     <!-- Tab links -->
                    <div class="tab" style="margin-left: 15px;">
                      <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Общая статистика (за все время)</button>
                      <button class="tablinks" onclick="openCity(event, 'Paris')">Статистика за квартал</button>
                      <button class="tablinks" onclick="openCity(event, 'Tokyo')">Статистика за месяц</button>
                      <button class="tablinks" >Статистика за неделю</button>
                    </div>

                    <!-- Tab content -->
                    <div id="London" class="tabcontent">
                        <div class="col-sm-10">
                            <div class="cards-content">
                                <div class="card">
                                    <div class="card-header">
                                            {{$period}}
                                    </div>
                                          <div class="card-body">
                                            <h5 class="card-title"></h5>
                                            <table class="table">
                                           <tr>
                                                <th>Общее время работы</th>
                                                <td>{{$totalTime}} ч. </td>
                                           </tr>
                                           <tr>
                                                <th>Средняя оценка</th>
                                                <td>{{ $avgMark  }}%</td>
                                           </tr>
                                           <tr>
                                                <th>Средняя (личная оценка)</th>
                                                <td>{{ $avgOwnMark }}%</td>
                                           </tr>
                                           <tr>
                                                <th>Медианная оценка</th>
                                                <td>{{$medianValue}}% </td>
                                           </tr>
                                           <tr>
                                                <th>Медианная личная оценка</th>
                                                <td>{{ $medianOwnValue }}% </td>
                                           </tr>
                                           <tr>
                                                <th>Максимальная оценка</th>
                                                <td>{{ $maxMark  }}% </td>
                                           </tr>
                                            <tr>
                                                <th>Минимальная оценка</th>
                                                <td>{{$minMark}}% </td>
                                            </tr>
                                            <tr>
                                                <th>Количество штрафов высшего порядка</th>
                                                <td>0 </td>
                                            </tr>
                                            </table>
                                            <hr/>
                                           {{-- <p class="text-bold text-left">Итого: <span class="text-center"> {{$histDayPlan[0]->time_of_day_plan}} часов </span></p>
                                            <p class="text-bold text-left">КПД: {{ $histDayPlan[0]->final_estimation > -1 ?  $histDayPlan[0]
                                                ->final_estimation." %"  : "-"}} | {{  $histDayPlan[0]->own_estimation != -1 ? $histDayPlan[0]->own_estimation: ''}}% </p>--}}
                                           </div>
                                          </div>
                                       </div>
                                    </div>
                    </div>
                    <div id="Paris" class="tabcontent">
                         <div class="col-sm-10">
                           <div class="cards-content">
                              <div class="card">
                                  <div class="card-header">
                                                                     :
                                  </div>
                                  <div class="card-body">
                                     <h5 class="card-title"></h5>
                                     <table class="table">
                                        <tr>
                                           <td>Общее время работы</td>
                                           <td>100 </td>
                                        </tr>
                                        <tr>
                                           <th>Средняя оценка</th>
                                           <td>100 </td>
                                        </tr>
                                        <tr>
                                           <th>Средняя (личная оценка)</th>
                                           <td>100 </td>
                                        </tr>
                                        <tr>
                                          <th>Медианная оценка</th>
                                          <td>100 </td>
                                        </tr>
                                        <tr>
                                          <th>Максимальная оценка</th>
                                          <td>100 </td>
                                        </tr>
                                        <tr>
                                          <th>Минимальная оценка</th>
                                          <td>100 </td>
                                        </tr>
                                        <tr>
                                            <th>Количество штррафов высшего порядка</th>
                                            <td>0 </td>
                                        </tr>
                                     </table>
                                                                     <hr/>
                                                                    {{-- <p class="text-bold text-left">Итого: <span class="text-center"> {{$histDayPlan[0]->time_of_day_plan}} часов </span></p>
                                                                     <p class="text-bold text-left">КПД: {{ $histDayPlan[0]->final_estimation > -1 ?  $histDayPlan[0]
                                                                         ->final_estimation." %"  : "-"}} | {{  $histDayPlan[0]->own_estimation != -1 ? $histDayPlan[0]->own_estimation: ''}}% </p>--}}
                                                                    </div>
                                                                   </div>
                                                                </div>
                    </div>

                    <div id="Tokyo" class="tabcontent">
                         <h3>История</h3>
                         <p>А здесь история..</p>
                    </div>


</div>

@endsection
</div>