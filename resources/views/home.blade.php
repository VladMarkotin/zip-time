
@extends('layouts.app')
@section('content')
    @livewire('add-log')
  
    @auth
        <a class="backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
            Add-log </a>
    @endauth

   
    <div class="container">
        @auth
            <v-app>
                <component v-bind:is="currComponentName" v-bind:data="currComponentProps">
            </v-app>
        @endauth
        @guest
            <h1>Index page</h1>
            <p class="text">Go to Login Page</p>
        @endguest
    </div>
@endsection
<style>
    #app {
        background: initial;
    }
</style>
