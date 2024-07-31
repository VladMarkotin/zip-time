@extends('layouts.app')
@section('content')
<div class="login-page-container ">
    <div class="inner-block">
        <section class="login-section white-background">
            <div class="login-icons-wrapper login-icons-top">
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 0L57.5788 49.5H0.421162L29 0Z" fill="#E60000"/>
                    </svg>
                </div>
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 50L0.421162 0.5L57.5788 0.5L29 50Z" fill="#E60000"/>
                    </svg>
                </div>
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 0L57.5788 49.5H0.421162L29 0Z" fill="#E60000"/>
                    </svg>
                </div>
               
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 50L0.421162 0.5L57.5788 0.5L29 50Z" fill="#E60000"/>
                    </svg>
                </div>
            </div>
            <div class="login-info">
                <h1 class="title-login-page main-title">Quipl.сo</h1>
                <h2 class="subtitle-login-page">The empire of efficiency is nearby. Final step left</h2>
            </div>
            <div class="login-links-wrapper">
                <div class="login-links-inner-block">
                    <div class="facebook-link-wrapper">
                        <Facebook/>
                    </div>  
                    <div class="privacy-policy-wrapper">
                        <div class="privacy-policy-text-wrapper">
                            <p class="privacy-policy-text">By using Quipl you accept</p>
                            <p class="privacy-policy-text">our <a href="{{ route('privacy.index') }}" class="privacy-policy-link">Privacy Policy</a></p>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="login-icons-wrapper login-icons-bottom">
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 0L57.5788 49.5H0.421162L29 0Z" fill="#E60000"/>
                    </svg>
                </div>
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 50L0.421162 0.5L57.5788 0.5L29 50Z" fill="#E60000"/>
                    </svg>
                </div>
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 0L57.5788 49.5H0.421162L29 0Z" fill="#E60000"/>
                    </svg>
                </div>
                <div class="login-icon-wrapper">
                    <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 50L0.421162 0.5L57.5788 0.5L29 50Z" fill="#E60000"/>
                    </svg>
                </div>
            </div>
        </section>
    </div>
    
                                   
</div>
@endsection
