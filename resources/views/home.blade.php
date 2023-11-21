
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
                        <h1>первый</h1>
                    </div>
                </div>
                <div class="slide slide-two" style="display: none;"> 
                    <div class="slide-content">
                        <h1>второй</h1>
                    </div>
                </div>
                <div class="slide slide-three" style="display: none;">
                    <div class="slide-content">
                        <h1>третий</h1>
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

