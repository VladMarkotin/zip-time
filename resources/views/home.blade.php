
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
        <section class="slider-section">
            <div class="slider-wrapper">
                <div class="slide slide-one">
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <span class="slide-content-3d-title">Hi there! Quipl has 4 questions<br class="br"> for you:</span>
                            <ul class="slide-one-list">
                                <li class="slide-one-li">
                                    <h3 class="slide-content-subtitle slide-one-title">Think you`re great but haven`t reached your potential yet?</h3>
                                </li>
                                <li class="slide-one-li">
                                    <h3 class="slide-content-subtitle slide-one-title">Wasting time instead self-developing?</h3>
                                </li>
                                <li class="slide-one-li">
                                    <h3 class="slide-content-subtitle slide-one-title">Sometimes don`t have enough self-discipline?</h3>
                                </li>
                                <li class="slide-one-li">
                                    <h3 class="slide-content-subtitle slide-one-title">Can`t find out how efficient you are?</h3>
                                </li>
                            </ul>
                            <div class="yeap-button-wrapper">
                                <button class="yeap-button">Yeap!</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide slide-two" style="display: none;"> 
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <div class="slide-content-text-wrapper">
                                <h2 class="slide-content-title"><span class="red-text">Quipl</span> is a day planing system which gonna solve all mentioned problems</h2>
                                <div class="slide-two-content">
                                    <h3 class="slide-content-subtitle">How it works?</h3>
                                    <ul class="slide-two-list">
                                        <li class="slide-two-li">
                                            <span class="slide-two-li-number slide-content-text">1 . </span>
                                            <p class="slide-content-text">Create day plan with plenty of<br class="br"> required jobs</p>
                                        </li>
                                        <li class="slide-two-li">
                                            <span class="slide-two-li-number slide-content-text">2 . </span>
                                            <p class="slide-content-text">Do it!</p>
                                        </li>
                                        <li class="slide-two-li">
                                            <span class="slide-two-li-number slide-content-text">3 . </span>
                                           <p class="slide-content-text">Evaluate yourself for every job. No deadline while day is not closed.</p>
                                        </li>
                                        <li class="slide-two-li">
                                            <span class="slide-two-li-number slide-content-text">4 . </span>
                                           <p class="slide-content-text">After all required jobs done,<br class="br"> close day plan and get your day efficiency</p>
                                        </li>
                                        <li class="slide-two-li">
                                            <span class="slide-two-li-number slide-content-text">5 . </span>
                                           <p class="slide-content-text"><span class="red-text">Congratulations!</span> Just see your history, statistic and realize you are awesome!</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="slide-content-button-wrapper">
                                    <button class="yeap-button">Cool!<br>Tell me more</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide slide-three" style="display: none;">
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <h2 class="slide-content-title">Wait.. wait.. But</h2>
                            <div class="slide-three-content">
                                <ul class="slide-three-list">
                                    <li class="slide-three-li">
                                        <span class="slide-three-li-number slide-content-text">1 . </span>
                                        <p class="slide-content-text">It`s hard to me to set a clearly defined task or to divide it<br class="br"> on subtasks <span ><svg xmlns="http://www.w3.org/2000/svg" class="smile-icon smile-icon-sad" viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5M14.77,17.23C14.32,16.5 13.25,16 12,16C10.75,16 9.68,16.5 9.23,17.23L7.81,15.81C8.71,14.72 10.25,14 12,14C13.75,14 15.29,14.72 16.19,15.81L14.77,17.23M15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5C17,10.3 16.3,11 15.5,11Z" /></svg></span></p>
                                    </li>
                                    <li class="slide-three-li">
                                        <span class="slide-three-li-number slide-content-text">2 . </span>
                                        <p class="slide-content-text">I doubt to start something new and complex cause I simply don`t know how to start <span ><svg xmlns="http://www.w3.org/2000/svg" class="smile-icon smile-icon-sad" viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5M14.77,17.23C14.32,16.5 13.25,16 12,16C10.75,16 9.68,16.5 9.23,17.23L7.81,15.81C8.71,14.72 10.25,14 12,14C13.75,14 15.29,14.72 16.19,15.81L14.77,17.23M15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5C17,10.3 16.3,11 15.5,11Z" /></svg></span></p>
                                    </li>
                                </ul>
                                <div class="slide-content-text-wrapper">
                                    <h3 class="slide-content-subtitle title-third-slide">Will Quipl help me?</h3>
                                    <h3 class="slide-content-subtitle subtitle-third-slide"><span class="red-text">Quipl</span> & <span class="red-text">ChatGPT</span><br class="br"> always ready to help <span><svg xmlns="http://www.w3.org/2000/svg" class="smile-icon smile-icon-cool" viewBox="0 0 24 24"><path d="M3.22,7.22C4.91,4.11 8.21,2 12,2C15.79,2 19.09,4.11 20.78,7.22L20,8H4L3.22,7.22M21.4,8.6C21.78,9.67 22,10.81 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12C2,10.81 2.22,9.67 2.6,8.6L4,10H5C5,11.38 7.12,12.5 8.5,12.5C9.88,12.5 11.25,11.38 11.25,10H12.75C12.75,11.38 14.12,12.5 15.5,12.5C16.88,12.5 19,11.38 19,10H20L21.4,8.6M16.19,15.42L14.77,14C14.32,14.72 13.25,15.23 12,15.23C10.75,15.23 9.68,14.72 9.23,14L7.81,15.42C8.71,16.5 10.25,17.23 12,17.23C13.75,17.23 15.29,16.5 16.19,15.42Z" /></svg></span></h3>
                                    <h3 class="slide-content-subtitle subtitle-third-slide">Key things you need are focus and constancy.<span class="just-try-it-wrapper"><a href="{{ route('register') }}"> Just try it!</a></span></h3>
                                </div>
                            </div>
                            <div class="slide-content-buttons-wrapper">
                                <a href="{{ route('login') }}">
                                    <button class="sign-button sing-in-button">sign in</button>
                                </a>
                                <a href="{{ route('register') }}">
                                    <button class="sign-button sign-up-button">sign up</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-left-arrow-wrapper slider-arrow transparent">
                    <svg class="slider-left-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" /></svg>
                </div>
            </div>
        </section>
        <section class="about-us-section white-background">
            <div class="inner-block">
                <div class="about-us-wrapper ">
                    <div class="about-us-title-wrapper">
                        <h2 class="about-us-title title-index-page">Have you answered “Yeap” at <br class="br">least once?</h2>
                    </div>
                    <div class="about-us-text-wrapper">
                        <p class="text-index-page">Welcome on board! Quipl gonna fix this points!</p>
                        
                        <ul class="about-us-list">
                            <li class="about-us-li about-us-item element-animation">
                                <span class="about-us-li-number text-index-page">1.</span>
                                <p class="text-index-page">Begin planning! Every day no less then 2 required tasks. The crucial word is “required”. If at least one task was`t completed, the plan failed</p>
                            </li>
                            <li class="about-us-li about-us-item element-animation">
                                <span class="about-us-li-number text-index-page">2.</span>
                                <p class="text-index-page">Do it! You got all day. You may complete all tasks in any order until day isn`t over (23:59)</p>
                            </li>
                            <li class="about-us-li about-us-item element-animation">
                                <span class="about-us-li-number text-index-page">3.</span>
                                <p class="text-index-page">After task is done - rate yourself. Put mark from 15% to 100%. The only and most honest judge is you!</p>
                            </li>
                            <li class="about-us-li about-us-item element-animation">
                                <span class="about-us-li-number text-index-page">4.</span>
                                <p class="text-index-page">After all tasks have been done - close day plan. If you forget to do this before the end of the day, Quipl will do it itself!</p>
                            </li>
                            <li class="about-us-li about-us-item element-animation">
                                <span class="about-us-li-number text-index-page">5.</span>
                                <p class="text-index-page"><span class="red-text">Congratulations!</span> Just see your history, statistic and realize you are awesome!</p>
                            </li>
                        </ul>
                    </div>
                    <div class="about-us-img-wrapper">
                        <img src="/images/index_page/about_us.jpg">
                    </div>
                </div>
            </div>
        </section>
        <section class="our-advantages-section">
            <div class="inner-block">
                <div class="our-advantages-wrapper element-animation">
                    <div class="our-advantages-title-wrapper">
                        <h2 class="our-advantages-title_main title-index-page">Why Quipl useful?</h2>
                    </div>
                    <div class="our-advantages-text-wrapper">
                        <p class="text-index-page">By using Quipl you get</p>
                    </div>
                    <div class="our-advantages-content">
                        <div class="our-advantages-item element-animation">
                            <div class="our-advantages-icon-wrapper">
                                <div class="our-advantages-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16,11.78L20.24,4.45L21.97,5.45L16.74,14.5L10.23,10.75L5.46,19H22V21H2V3H4V17.54L9.5,8L16,11.78Z" /></svg>
                                </div>
                            </div>
                            <div class="our-advantages-title-wrapper">
                                <h3 class="title-index-page our-advantages-title">Statistic</h3>
                            </div>
                            <div class="our-advantages-text">
                                <p class="text-index-page ">Now you will always know your efficiency. Moreover, you will be able to observe the dynamics of your success. No more rhetorical questions about whether you are doing enough</p>
                            </div>
                        </div>
                        <div class="our-advantages-item element-animation">
                            <div class="our-advantages-icon-wrapper">
                                <div class="our-advantages-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,3C10.73,3 9.6,3.8 9.18,5H3V7H4.95L2,14C1.53,16 3,17 5.5,17C8,17 9.56,16 9,14L6.05,7H9.17C9.5,7.85 10.15,8.5 11,8.83V20H2V22H22V20H13V8.82C13.85,8.5 14.5,7.85 14.82,7H17.95L15,14C14.53,16 16,17 18.5,17C21,17 22.56,16 22,14L19.05,7H21V5H14.83C14.4,3.8 13.27,3 12,3M12,5A1,1 0 0,1 13,6A1,1 0 0,1 12,7A1,1 0 0,1 11,6A1,1 0 0,1 12,5M5.5,10.25L7,14H4L5.5,10.25M18.5,10.25L20,14H17L18.5,10.25Z" /></svg>
                                </div>
                            </div>
                            <div class="our-advantages-title-wrapper">
                                <h3 class="title-index-page our-advantages-title">Responsibility</h3>
                            </div>
                            <div class="our-advantages-text">
                                <p class="text-index-page ">No more “I will think about it tomorrow”. Start getting things done right now! Yes, it may be very difficult to do something. You don't have to do everything perfectly right away. But it's important just do And, gradually youwill achieve the ideal</p>
                            </div>
                        </div>
                        <div class="our-advantages-item element-animation">
                            <div class="our-advantages-icon-wrapper">
                                <div class="our-advantages-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13.5,8H12V13L16.28,15.54L17,14.33L13.5,12.25V8M13,3A9,9 0 0,0 4,12H1L4.96,16.03L9,12H6A7,7 0 0,1 13,5A7,7 0 0,1 20,12A7,7 0 0,1 13,19C11.07,19 9.32,18.21 8.06,16.94L6.64,18.36C8.27,20 10.5,21 13,21A9,9 0 0,0 22,12A9,9 0 0,0 13,3" /></svg>
                                </div>
                            </div>
                            <div class="our-advantages-title-wrapper">
                                <h3 class="title-index-page our-advantages-title">History</h3>
                            </div>
                            <div class="our-advantages-text">
                                <p class="text-index-page ">Every success and every mistake has its own story. Quipl will help you remember successes and draw conclusions from mistakes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="statistics-section">
            <div class="inner-block">
                <div class="statistics-content">
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <svg class="statistics-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7,10H12V15H7M19,19H5V8H19M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" /></svg>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2  data-counterVal={{ $statData['created'] }} class="statistics-counter title-index-page">0</h2>        
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Total number of plans per day </p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <svg class="statistics-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" /></svg>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 data-counterVal={{ $statData['completed_tasks'] }} class="statistics-counter title-index-page">0</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Tasks are successfully completed</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <svg class="statistics-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z" /></svg>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 data-counterVal={{ $statData['completed_days'] }} class="statistics-counter title-index-page">0</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Days are successfully completed</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <svg class="statistics-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19,7H11V14H3V5H1V20H3V17H21V20H23V11A4,4 0 0,0 19,7M7,13A3,3 0 0,0 10,10A3,3 0 0,0 7,7A3,3 0 0,0 4,10A3,3 0 0,0 7,13Z" /></svg>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 data-counterVal={{ $statData['weekends'] }} class="statistics-counter title-index-page">0</h2>
                            
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Deserved weekends amount</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="philosofy-section white-background">
            <div class="philosofy-inner-block">
                <div class="philosofy-wrapper">
                    <div class="philosofy-title-wrapper">
                        <h2 class="philosofy-title title-index-page">Quipl's philosofy</h2>
                    </div>
                    <div class="philosofy-slider-wrapper">
                        <div class="philosofy-slider">
                            <div class="philosofy-slider-line">
                                <div class="philosofy-slide philosofy-slide-one">
                                    <div class="philosofy-slide-text-wrapper">
                                        <p class="philosofy-slide-text text-index-page">Quipl has borrowed crutial ideas from “Getting Things Done” (GTD) method but we complemented it with some intresting points:</p>
                                    </div>
                                    <div class="philosofy-list-wrapper">
                                        <ul class="philosofy-list">
                                            <li class="philosofy-li philosofy-item element-animation">
                                                <span class="philosofy-li-number philosofy-slide-text text-index-page">1 .</span>
                                                <p class="philosofy-slide-text text-index-page">The daily plan should consist of at least 2 required jobs.</p>
                                            </li>
                                            <li class="philosofy-li philosofy-item element-animation">
                                                <span class="philosofy-li-number philosofy-slide-text text-index-page">2 .</span>
                                                <p class="philosofy-slide-text text-index-page">You can't canceled or “fail” none of them.</p>
                                            </li>
                                            <li class="philosofy-li philosofy-item element-animation">
                                                <span class="philosofy-li-number philosofy-slide-text text-index-page">3 .</span>
                                                <p class="philosofy-slide-text text-index-page">To “fail” means do not have time to grade the assignment before the end of the day (23:59)</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="philosofy-slide philosofy-slide-two">
                                <div class="philosofy-list-wrapper">
                                        <ul class="philosofy-list">
                                            <li class="philosofy-li">
                                                <span class="philosofy-li-number philosofy-slide-text text-index-page">4 .</span>
                                                <p class="philosofy-slide-text text-index-page">You evaluate yourself :) You are the only one who can do this accurately. Evaluate yourself for each job.</p>
                                            </li>
                                            <li class="philosofy-li">
                                                <span class="philosofy-li-number philosofy-slide-text text-index-page">5 .</span>
                                                <p class="philosofy-slide-text text-index-page">In the end of the day (23:59) Quipl will automatically closed your day plan </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="philosofy-slider-buttons">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="quotes-section">
            <div class="inner-block">
                <div class="quotes-wrapper">
                    <div class="quotes-content">
                        <div class="quotes-list-wrapper">
                            <ul class="quotes-list">
                                <li class="quotes-li quotes-item element-animation">
                                    <div class="quotes-text text-index-page">“The most precious resource we all have is time”</div>
                                    <div class="quotes-author">― Steve Jobs</div>
                                </li>
                                <li class="quotes-li quotes-item element-animation">
                                    <div class="quotes-text text-index-page">“We must use time creatively - and forever realize that the time is always hope to do great things.”</div>
                                    <div class="quotes-author">― Martin Luther King Jr</div>
                                </li>
                                <li class="quotes-li quotes-item element-animation">
                                    <div class="quotes-text text-index-page">“The wisest are the most annoyed at the loss of time”</div>
                                    <div class="quotes-author">― Dante Alighieri</div>
                                </li>
                            </ul>
                        </div>
                    </div>
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

