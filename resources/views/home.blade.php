
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
                                </div>
                            </div>
                            <div class="our-advantages-title-wrapper">
                                <h3 class="title-index-page our-advantages-title">some title</h3>
                            </div>
                            <div class="our-advantages-text">
                                <p class="text-index-page ">Lorem ipsum dolor sit amet adipisicing elit. Necessitatibus nihil ipsam deleniti voluptatum.</p>
                            </div>
                        </div>
                        <div class="our-advantages-item element-animation">
                            <div class="our-advantages-icon-wrapper">
                                <div class="our-advantages-icon">
                                </div>
                            </div>
                            <div class="our-advantages-title-wrapper">
                                <h3 class="title-index-page our-advantages-title">some title</h3>
                            </div>
                            <div class="our-advantages-text">
                                <p class="text-index-page ">Lorem ipsum dolor sit amet adipisicing elit. Necessitatibus nihil ipsam deleniti voluptatum.</p>
                            </div>
                        </div>
                        <div class="our-advantages-item element-animation">
                            <div class="our-advantages-icon-wrapper">
                                <div class="our-advantages-icon">
                                </div>
                            </div>
                            <div class="our-advantages-title-wrapper">
                                <h3 class="title-index-page our-advantages-title">some title</h3>
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
                            <div class="statistics-icon"></div>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 class="statistics-counter title-index-page">360</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Lorem ipsum dolor</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <div class="statistics-icon"></div>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 class="statistics-counter title-index-page">690</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Lorem ipsum dolor</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <div class="statistics-icon"></div>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 class="statistics-counter title-index-page">420</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Lorem ipsum dolor</p>
                        </div>
                    </div>
                    <div class="statistics-item element-animation">
                        <div class="statistics-icon-wrapper">
                            <div class="statistics-icon"></div>
                        </div>
                        <div class="statistics-counter-wrapper">
                            <h2 class="statistics-counter title-index-page">114</h2>
                        </div>
                        <div class="statistics-text-wrapper">
                            <p class="statistics-text text-index-page">Lorem ipsum dolor</p>
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
                                        <div class="reviews-slide-icon">1</div>
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
                                        <div class="reviews-slide-icon">2</div>
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
                                        <div class="reviews-slide-icon">3</div>
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

