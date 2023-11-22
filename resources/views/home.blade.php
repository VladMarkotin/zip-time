
@extends('layouts.app')
@section('content')

        @auth
        <div class="container">
            <v-app>
                <component v-bind:is="currComponentName" v-bind:data="currComponentProps">
            </v-app>
        </div>
        @endauth 
        @guest
        <section>
            <div class="slider-wrapper">
                <div class="slide slide-one">
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <span class="slide-content-subtitle">добро пожаловать</span>
                            <h2 class="slide-content-title">тут какой-то текст</h2>
                        </div>
                    </div>
                </div>
                <div class="slide slide-two" style="display: none;"> 
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <span class="slide-content-subtitle">добро пожаловать</span>
                            <h2 class="slide-content-title">тут какой-то текст</h2>
                        </div>
                    </div>
                </div>
                <div class="slide slide-three" style="display: none;">
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <span class="slide-content-subtitle">добро пожаловать</span>
                            <h2 class="slide-content-title">тут какой-то текст</h2>
                        </div>
                    </div>
                </div>
                <div class="slider-left-arrow-wrapper slider-arrow">
                    
                </div>
            </div>
        </section>
        @endguest
    
@endsection
<style>
    #app {
        background: initial;
    }
</style>

