
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
                <div class="about-us-wrapper">
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
                <div class="our-advantages-wrapper">
                    <div class="our-advantages-title-wrapper">
                        <h2 class="our-advantages-title title-index-page">some title</h2>
                    </div>
                    <div class="our-advantages-text-wrapper">
                        <p class="text-index-page">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sunt, et!</p>
                    </div>
                    <div class="our-advantages-content">
                        <div class="our-advantages-item">
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
                        <div class="our-advantages-item">
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
                        <div class="our-advantages-item">
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
        @endguest
    
@endsection
<style>
    #app {
        background: initial;
    }
</style>

