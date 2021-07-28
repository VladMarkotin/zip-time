@extends('layouts.app')

@section('content')
<div class="container">
<v-app>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background-color: #A10000; color:#FFFFFF">Create your day plan!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <plan-component>
                    </plan-component>
                </div>
            </div>
        </div>
    </div>
</v-app>
</div>
@endsection
