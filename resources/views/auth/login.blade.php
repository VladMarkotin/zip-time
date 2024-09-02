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
                    <div style="background: #000;">
                    <a
                       href="login/google"
                       class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">
                        <svg class="w-1 h-1 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                        <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
                        </svg>
                        Sign in with Google
                    </a>
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
