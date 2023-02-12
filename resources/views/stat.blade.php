@extends('layouts.app')
@section('content')
@if (Auth::check())
<a class="backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
    Add-log </a>
@endif
    <div class="container">
        <h1>Statistics</h1>
        <v-app>
            <Stat />
        </v-app>
    </div>
@endsection
