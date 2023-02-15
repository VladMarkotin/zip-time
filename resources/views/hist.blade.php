@extends('layouts.app')
@section('content')
@if (Auth::check())
<a class="backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
    Add-log </a>
@endif
    <div class="container">
        <h1>History</h1>
        <v-app>
            <History />
        </v-app>
    </div>
@endsection