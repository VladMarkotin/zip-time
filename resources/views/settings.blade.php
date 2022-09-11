@extends('layouts.app')

@section ('content')
<div class="content">
   @livewire('settings')
</div>
@livewire('add-log')

	@if (Auth::check())
	 <a class = "backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
        <i type="submit" class="fa fa-plus-square" style="color: #A10000; font-size: 35px"></i>
    </a>	
	@endif 

@endsection