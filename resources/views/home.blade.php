@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="card col-md-4 rounded-3" id="notification_panel">
            <div class="card-header ">
                <h4 class="text-danger fw-semibold">
                    Notifications
                
                </h4>
            </div>

            <div class="list-group">

                @if (Auth::check())
                     @foreach ($notifications as $notification)
                    <span class="notification" id="{{ $notification->id }}">
                        <input type="hidden" id="data" name="data" value="{{ $notification->data }}">

                        <a class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">

                                <span class="mb-1" id="content{{ $notification->id }}">

                                    @if ($notification->read_at == 0)
                                        <strong>
                                            {{ $notification->data }}

                                        </strong>
                                    @else
                                        {{ $notification->data }}
                                    @endif

                                </span>
                                <small
                                    class="text-success">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                            </div>                         
                        </a>
                    </span>
                    @endforeach
                @endif

               
            </div>
        </div>

        <v-app>
            <button style="text-decoration: underline;" v-on:click="currComponent.name = 'Stat'">Statistics</button>
            <component v-bind:is="currComponentName" v-bind:data="currComponentProps">
        </v-app>
    </div>
@endsection
<style>
    #app {
        background: initial;
    }
</style>
