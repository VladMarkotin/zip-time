@extends('layouts.app')

@section ('content')
<script src="{{ asset('js/fadeInSettingsBlocks.js') }}"></script>

<div class="content">
   @livewire('settings')
</div>
@livewire('add-log')

	@if (Auth::check())
	<a class="backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
        add-log 
    </a>	
	@endif 

@endsection