
@extends('layouts.app')
@section('content')
    @livewire('add-log')
  
    @auth
        <a class="backlog-add-button" data-bs-toggle="modal" data-bs-target="#AddbacklogModal">
            Add-log </a>
    @endauth

    
   
    
        @auth
        <div class="container">
            <v-app>
                <component v-bind:is="currComponentName" v-bind:data="currComponentProps">
            </v-app>
        </div>
        @endauth 
        @guest
        <div class="index-container">
            <div class="banner">
                <h1 class="slogan">Quipl.io slogan</h1>
                <p class="info-head info-banner">manage and control</p>
                <p class="info-text text-banner">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                <img class="banner-gif-left" src="/images/ezgif.com-gif-maker.gif">
                <img class="banner-gif-right" src="/images/ezgif.com-gif-maker.gif" >
            </div>
            <div class="info">
                <div class="info-container">
                    <p class="info-head move-right-head text-left">statistic</p>
                    <p class="info-bold move-right-bold-text text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    <p class="info-text move-right-text text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <img class="statistic-img" src="/images/statistic.png">
                </div>
                <hr class="underline">            
                <div class="info-container right-container">
                    <p class="info-head text-right">#saved task</p>
                    <p class="info-bold text-right">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    <p class="info-text text-right">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <div class="images">
                        <img class="saved-task-img" src="/images/clock.png">
                        <img class="saved-img" src="/images/saved.png">
                        <img class="task-img" src="/images/task.png">
                    </div>                
                </div>
                <hr class="underline">
                <div class="info-container">
                    <p class="info-head move-left-head text-left">history</p>
                    <p class="info-bold text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    <p class="info-text text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <img class="history-img" src="/images/history.png">
                </div>
            </div>
        </div> 
        @endguest
    
@endsection
<style>
    #app {
        background: initial;
    }
</style>
