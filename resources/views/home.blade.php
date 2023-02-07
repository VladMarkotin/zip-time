@extends('layouts.app')
@section('content')
    @livewire('add-log')

    @if (Auth::check())
        <a class="backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
            Add-log </a>
    @endif
    <div class="container">
        <v-app>
            <div>
                <button style="text-decoration: underline;" v-on:click="currComponent.name = 'Stat'">Statistics</button>
                <button style="text-decoration: underline;" v-on:click="currComponent.name = 'History'">History</button>
            </div>
            <component v-bind:is="currComponentName" v-bind:data="currComponentProps">
        </v-app>
    </div>
@endsection
<style>
    #app {
        background: initial;
    }
</style>
