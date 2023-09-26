@extends('layouts.app')

@section ('content')

<div class="container">
    <div class="row">
        <h1>{{$sT->hash_code}}</h1>
        <div class="col-12">
            <table class="table table-bordered table-hover">
                <tr>
                    <td width="25%" class="left-column">Task name</td>
                    <td>{{$sT->task_name }}</td>
                </tr>
                <tr>
                    <td class="left-column">Type</td>
                    <td>{{$sT->type}}</td>
                </tr>
                <tr>
                    <td class="left-column">Priority</td>
                    <td>{{$sT->priority}}</td>
                </tr>
                <tr>
                    <td class="left-column">Details</td>
                    <td>{{$sT->details}}</td>
                </tr>
                <tr>
                    <td class="left-column">Time</td>
                    <td>{{$sT->time}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection