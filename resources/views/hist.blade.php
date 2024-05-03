@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>History</h1>
        <v-app style="position: static"> 
            {{-- position: static добавлен так как пытался решить проблему выхода карточки задания за пределы экрана 
            при клике на календарь --}}
            <History />
        </v-app>
    </div>
@endsection