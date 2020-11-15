@extends('layouts.app')
<div class="content">

@if($history)
@section ("hist_cards")



@foreach($history as $k => $v)
<div class="row justify-content-center">


            <div class="col-sm-5 text-center">
              <div class="cards-content">
                <div class="card">
                  <div class="card-header">
                   <p class="text-center"> Текущий статус: {{$history[$k]->day_status}}</p>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">План на день: ({{ $history[$k]->date }})</h5>
                    <a href="hist/{{$history[$k]->date}}" class="btn btn-primary">Посмотреть</a>
                   </div>
                  </div>
               </div>
            </div>

</div>
@endforeach
@endsection
   @endif

</div>