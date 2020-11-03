@extends('layouts.app')
<div class="content">
@section ("hist_cards")
<div class="row">
    @if($history)
        @foreach($history as $k => $v)
            <div class="col-sm-5 text-center">
              <div class="cards-content">
                <div class="card">
                  <div class="card-header">
                    Featured
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">План на день: ({{ $history[$k]->date }})</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="hist/{{$history[$k]->date}}" class="btn btn-primary">Go somewhere</a>
                   </div>
                  </div>
               </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
</div>