@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-container">
                <div class="auth-info">                    
                    <div class="auth-text">
                        To continue using Quipl.io you have to Log in with your Facebook account
                    </div>
                </div>
                <div class="card auth-card">
                    <img class="facebook-ico" src="/images/facebook.png">
                    <div class="facebook-link">
                        <Facebook/>
                    </div>                                    
                </div>
            </div>            
        </div>
    </div>
</div>
@endsection
