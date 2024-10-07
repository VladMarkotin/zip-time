@extends('layouts.app')
@section('content')

    <div class="container">
        <v-app> 
            <Plan 
            :selected-plan-date = {{json_encode($selected_plan_date)}}
            :user-today-date    = {{json_encode($user_today_date)}}
            />
        </v-app>
    </div>
@endsection