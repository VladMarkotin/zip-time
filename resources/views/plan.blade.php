@extends('layouts.app')
@section('content')

    <div class="container">
        <v-app> 
            <Plan 
            :selected-plan-date = {{json_encode($selectedPlanDate)}}
            />
        </v-app>
    </div>
@endsection