
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
                            <span class="slide-content-subtitle">some text</span>
                            <h2 class="slide-content-title">some title</h2>
                        </div>
                    </div>
                </div>
                <div class="slide slide-two" style="display: none;"> 
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <span class="slide-content-subtitle">some text</span>
                            <h2 class="slide-content-title">some title</h2>
                        </div>
                    </div>
                </div>
                <div class="slide slide-three" style="display: none;">
                    <div class="slide-content">
                        <div class="slide-content_inner-block">
                            <span class="slide-content-subtitle">some text</span>
                            <h2 class="slide-content-title">some title</h2>
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
                <div class="about-us-wrapper element-animation">
                    <div class="about-us-title-wrapper">
                        <h2 class="about-us-title title-index-page">some title</h2>
                    </div>
                    <div class="about-us-text-wrapper">
                        <p class="text-index-page">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem eveniet iusto magni temporibus. Perspiciatis non ut, natus deleniti odio aliquid ducimus perferendis saepe quibusdam veritatis qui sint harum similique consectetur inventore doloribus dolor quae dolores earum adipisci recusandae aut accusantium.</p>
                        
                        <p class="text-index-page">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laudantium, sunt, vero consequatur magni natus molestiae adipisci commodi quaerat quia pariatur exercitationem. Quia hic sint aut vel quisquam? Molestiae, laboriosam numquam, maxime quasi culpa, quo incidunt eligendi quia aperiam reprehenderit dolorum?</p>
                    </div>
                    <div class="about-us-img-wrapper">
                        <img src="/images/index_page/home_slider1.jpg">
                    </div>
                </div>
            </div>
        </section>
        <section class="our-advantages-section">
            <div class="inner-block">
                <div class="our-advantages-wrapper element-animation">
                    <div class="our-advantages-title-wrapper">
                        <h2 class="our-advantages-title title-index-page">some title</h2>
                    </div>
                    <div class="our-advantages-text-wrapper">
                        <p class="text-index-page">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sunt, et!</p>
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
                                <p class="text-index-page ">Lorem ipsum dolor sit amet adipisicing elit. Necessitatibus nihil ipsam deleniti voluptatum.</p>
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
                                <p class="text-index-page ">Lorem ipsum dolor sit amet adipisicing elit. Necessitatibus nihil ipsam deleniti voluptatum.</p>
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
                                <p class="text-index-page ">Lorem ipsum dolor sit amet adipisicing elit. Necessitatibus nihil ipsam deleniti voluptatum.</p>
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
                            <h2 class="statistics-counter title-index-page">360</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Total day plans created</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <svg class="statistics-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" /></svg>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 class="statistics-counter title-index-page">690</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Successfully completed tasks</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <svg class="statistics-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z" /></svg>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 class="statistics-counter title-index-page">420</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Successfully completed days</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <svg class="statistics-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19,7H11V14H3V5H1V20H3V17H21V20H23V11A4,4 0 0,0 19,7M7,13A3,3 0 0,0 10,10A3,3 0 0,0 7,7A3,3 0 0,0 4,10A3,3 0 0,0 7,13Z" /></svg>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 class="statistics-counter title-index-page">114</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Total weekends taken</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="reviews-section">
            <div class="reviews-inner-block">
                <div class="reviews-wrapper">
                    <div class="reviews-slider-wrapper element-animation">
                        <div class="reviews-slider">
                            <div class="reviews-slider-line">
                                <div class="reviews-slide reviews-slide-one">
                                    <div class="reviews-slide-icon-wrapper">
                                        <svg class="reviews-slide-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" /></svg>
                                    </div>
                                    <div class="reviws-slide-title-wrapper">
                                        <h3 class="reviws-slide-title title-index-page">Some title</h3>
                                    </div>
                                    <div class="reviews-slide-text-wrapper">
                                        <p class="reviews-slide-text text-index-page">"Lorem ipsum dolor sit amet consectetur adipisicing elit. A unde in accusantium cum necessitatibus optio itaque soluta explicabo debitis obcaecati."</p>
                                    </div>
                                    <div class="reviews-slide-author-wrapper">
                                       <p class="reviews-slide-author text-index-page">Lorem ipsum dolor sit amet.</p>
                                    </div>
                                </div>
                                <div class="reviews-slide reviews-slide-two">
                                    <div class="reviews-slide-icon-wrapper">
                                        <svg class="reviews-slide-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" /></svg>
                                    </div>
                                    <div class="reviws-slide-title-wrapper">
                                        <h3 class="reviws-slide-title title-index-page">Some title</h3>
                                    </div>
                                    <div class="reviews-slide-text-wrapper">
                                        <p class="reviews-slide-text text-index-page">"Lorem ipsum dolor sit amet consectetur adipisicing elit. A unde in accusantium cum necessitatibus optio itaque soluta explicabo debitis obcaecati."</p>
                                    </div>
                                    <div class="reviews-slide-author-wrapper">
                                       <p class="reviews-slide-author text-index-page">Lorem ipsum dolor sit amet.</p>
                                    </div>
                                </div>
                                <div class="reviews-slide reviews-slide-three">
                                    <div class="reviews-slide-icon-wrapper">
                                        <svg class="reviews-slide-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" /></svg>
                                    </div>
                                    <div class="reviws-slide-title-wrapper">
                                        <h3 class="reviws-slide-title title-index-page">Some title</h3>
                                    </div>
                                    <div class="reviews-slide-text-wrapper">
                                        <p class="reviews-slide-text text-index-page">"Lorem ipsum dolor sit amet consectetur adipisicing elit. A unde in accusantium cum necessitatibus optio itaque soluta explicabo debitis obcaecati."</p>
                                    </div>
                                    <div class="reviews-slide-author-wrapper">
                                       <p class="reviews-slide-author text-index-page">Lorem ipsum dolor sit amet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reviews-slider-buttons">
                            
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

