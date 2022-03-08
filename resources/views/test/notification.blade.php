@extends('layouts.app')

@section('content')
@if(count($notifications))
   @forelse($notifications as $notification)
   <div class="alert alert-success" role="alert">
   [{{ $notification->created_at }}] Notification: {{ $notification->data['data'] }}
   <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
   Mark as read
   </a>
   </div>

   $loop->last
   <a href="#" id="mark-all">
   Mark all as read
   </a>
   @empty
   There are no new notifications
   @endforelse
@endif
<div class="content">
   <form action="{{ route('notify.store') }}" method="post">
     @csrf
     <div class="form-group">
         <label for="exampleInputPassword1">Date</label>
         <input type="date" class="form-control" id="exampleInputPassword1" name="date">
      </div>
     <div class="form-group">
       <label for="exampleInputPassword1">Time</label>
       <input type="time" class="form-control" id="exampleInputPassword1" name="time">
     </div>
     <div class="form-group">
         <label for="exampleFormControlTextarea1">Text of remind</label>
         <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
     </div>
     <div class="form-group form-check">
           <input type="checkbox" class="form-check-input" id="exampleCheck1" name="is_active">
           <label class="form-check-label" for="exampleCheck1">Turn On?</label>
     </div>
     <button type="submit" class="btn btn-primary">Submit</button>
   </form>
</div>
@endsection