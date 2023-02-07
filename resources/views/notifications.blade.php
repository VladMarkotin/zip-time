@extends('layouts.app')
@section('content')

@livewire('notifications')
@if (Auth::check())
<a class="backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">

    add-log </a>
@endif
@endsection