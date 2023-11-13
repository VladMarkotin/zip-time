
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
        <section class="slider-area">
    <div class="slider-active">
        <div class="single-slider">
            <div class="slider-img parallax-bg bg-opacity-black-60" style="background:url(img/home_slider/home_slider1.jpg)"></div>
            <div class="slider-content slider-style-2 slider-style-4 text-center z-index-5">
                <span>Добро пожаловать</span>
                <h2>Digital-агентство<br> We Coders</h2>
                <a class="my-button" href="#about_us">Подробнее</a>
            </div>
        </div>
        <div class="single-slider">
            <div class="slider-img parallax-bg bg-opacity-black-60" style="background:url(img/home_slider/home_slider2.jpg)"></div>
            <div class="slider-content slider-style-2 slider-style-4 text-center z-index-5">
                <span>Работайте с лучшими</span>
                <h2>Судите по результатам</h2>
                <a class="my-button" href="#portfolio">Смотреть работы</a>
            </div>
        </div>
        <div class="single-slider">
            <div class="slider-img parallax-bg bg-opacity-black-60" style="background:url(img/home_slider/home_slider3.jpg)"></div>
            <div class="slider-content slider-style-2 slider-style-4 text-center z-index-5">
                <span>Большой опыт</span>
                <h2>Классный результат</h2>
                <!--<a class="my-button" href="#portfolio">Смотреть работы</a>-->
            </div>
        </div>
    </div>
</section>

<!-- О нас -->
<section class="who-area-are pad-90" id="about_us">
    <div class="container">
        <h2 class="title-1">О нас</h2>
        <div class="row">
            <div class="col-md-7">
                <div class="who-we">
                    <p>Мы в <b>WeCoders</b> считаем, что любую задачу, даже которая кажется «невозможной» можно
                       решить, чем мы успешно и занимаемся! У нас собрались только творческие и ответственные
                       люди,которым под силу решить любую проблему в сфере digital, чтобы помочь другим бизнесам
                       достичь своих целей. </p>
                    <p>Используя накопленный за многие годы опыт работы с крупными мировыми корпорациями, мы создаем
                       творческие инновации, которые обеспечивают реальные результаты. Прокрутите вниз, чтобы узнать
                       немного о том, кто делает все это.</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="about-bg">
                    <img src="img/about/o_nas_text_block.jpg" alt=""/>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Основные направления -->
<section class="service-area pt-90 pb-60 bg-color">
    <div class="container">
        <div class="row">
            <div class="section-heading text-center mb-70">
                <h2>Основные направления</h2>
                <p>Всё что нужно для производства сайта любой сложности</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="single-service brand-hover radius-4 mb-30 text-center">
                    <div class="service-icon">
                        <span class="icon-tools " aria-hidden="true"></span>
                    </div>
                    <div class="service-text">
                        <h3>Web-дизайн</h3>
                        <p>Создание индивидуальной концепции, от лаконичных решений до сложных динамических
                           элементов.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="single-service brand-hover radius-4 mb-30 text-center">
                    <div class="service-icon">
                        <span class="icon-mobile" aria-hidden="true"></span>
                    </div>
                    <div class="service-text">
                        <h3>Frontend</h3>
                        <p>Красивая и отзывчивая <b>frontend</b> часть сайта, которая будет отлично работать на всех
                           разрешениях и устройствах.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="single-service brand-hover radius-4 mb-30 text-center">
                    <div class="service-icon">
                        <span class="icon-tools-2" aria-hidden="true"></span>
                    </div>
                    <div class="service-text">
                        <h3>Backend</h3>
                        <p>Стабильный и быстрый <b>backend</b> сайта с гибкой админкой и высоким уровнем безопасности.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Инфографика -->
<section class="project-count-area brand-bg pad-90">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="single-count white-text text-center">
                    <span class="icon-briefcase "></span>
                    <h2 class="counter">360</h2>
                    <p>Готовых проектов</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-count white-text text-center">
                    <span class="icon-wine "></span>
                    <h2 class="counter">690</h2>
                    <p>Чашек кофе выпито</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-count white-text text-center">
                    <span class="icon-lightbulb"></span>
                    <h2 class="counter">420</h2>
                    <p>Воплотили супер-йдей</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-count white-text text-center">
                    <span class="icon-happy"></span>
                    <h2 class="counter">115</h2>
                    <p>Счастливых клиентов</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Наши работы -->


<section class="work-area pt-90 pb-60" id="portfolio">
    <div class="container">
        <div class="row">
            <div class="section-heading text-center mb-70">
                <h2>Портфолио</h2>
                <p>Лучший способ найти хорошую команду - это посмотреть результаты её работы</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portfolio-menu brand-filter text-center mb-70">
                    <div class="filter" data-filter="all">Все</div>
                    <div class="filter" data-filter=".landing">Лендинги</div>
                    <div class="filter" data-filter=".internet_shop">Интренет магазины</div>
                    <div class="filter" data-filter=".promo">Промо сайты</div>
                    <div class="filter" data-filter=".corporative_site">Корпоративные порталы</div>
                </div>
            </div>
            <div id="Container">
                <div class="col-md-4 col-sm-6 col-xs-12 mb-30 mix landing promo">
                    <div class="portfolio-wrapper portfolio-title">
                        <div class="portfolio-img">
                            <img src="img/portfolio/1.jpg" alt=""/>
                            <div class="work-text brand-bg">
                                <div class="inner-text">
                                    <a class="view-portfolio image-link" href="img/portfolio/1.jpg">
                                        <span class="plus"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-heading pd-15">
                            <h4 class="mb-10">
                                <a href="#">Green Planet</a>
                            </h4>
                            <h5 class="m-0">Дизайн</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-30 mix internet_shop corporative_site">
                    <div class="portfolio-wrapper portfolio-title">
                        <div class="portfolio-img">
                            <img src="img/portfolio/2.jpg" alt=""/>
                            <div class="work-text brand-bg">
                                <div class="inner-text">
                                    <a class="view-portfolio image-link" href="img/portfolio/2.jpg">
                                        <span class="plus"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-heading pd-15">
                            <h4 class="mb-10">
                                <a href="#">Creative developer</a>
                            </h4>
                            <h5 class="m-0">Разработка лендинга</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-30 mix landing">
                    <div class="portfolio-wrapper portfolio-title">
                        <div class="portfolio-img">
                            <img src="img/portfolio/3.jpg" alt=""/>
                            <div class="work-text brand-bg">
                                <div class="inner-text">
                                    <a class="view-portfolio image-link" href="img/portfolio/3.jpg"><span class="plus"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-heading pd-15">
                            <h4 class="mb-10">
                                <a href="portfolio_online_shop.html">Dress & Jeans</a>
                            </h4>
                            <h5 class="m-0">Разработка интернет-магазина</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-30 mix internet_shop">
                    <div class="portfolio-wrapper portfolio-title">
                        <div class="portfolio-img">
                            <img src="img/portfolio/4.jpg" alt=""/>
                            <div class="work-text brand-bg">
                                <div class="inner-text">
                                    <a class="view-portfolio image-link" href="img/portfolio/4.jpg"><span
                                            class="plus"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-heading pd-15">
                            <h4 class="mb-10">
                                <a href="portfolio_landing.html">Mountain King</a>
                            </h4>
                            <h5 class="m-0">Разработка сайта визитки</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-30 mix corporative_site">
                    <div class="portfolio-wrapper portfolio-title">
                        <div class="portfolio-img">
                            <img src="img/portfolio/5.jpg" alt=""/>
                            <div class="work-text brand-bg">
                                <div class="inner-text">
                                    <a class="view-portfolio image-link" href="img/portfolio/5.jpg">
                                        <span class="plus"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-heading pd-15">
                            <h4 class="mb-10">
                                <a href="#">Beauty SPA</a>
                            </h4>
                            <h5 class="m-0">Разработка сайта визитки</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-30 mix promo">
                    <div class="portfolio-wrapper portfolio-title">
                        <div class="portfolio-img">
                            <img src="img/portfolio/6.jpg" alt=""/>
                            <div class="work-text brand-bg">
                                <div class="inner-text">
                                    <a class="view-portfolio image-link" href="img/portfolio/6.jpg"><span class="plus"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-heading pd-15">
                            <h4 class="mb-10">
                                <a href="#">Bent Application</a>
                            </h4>
                            <h5 class="m-0">Разработка лендинга</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- Отзывы клиентов -->
<section class="testimonial-area bg-color pad-90">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="testimonial-active dots-style">
                    <div class="single-testimonial black-text text-center">
                        <div class="testimonial-title">
                            <span class="icon-quote"></span>
                            <h3 class="black-text">Сроки не проблема!</h3>
                        </div>
                        <p><span>"</span>Спасут любой проект с самыми горящими сроками! Ребята действительно
                                         профессионалы своего дела.<span>"</span>
                        </p>
                        <div class="testimonial-author text-uppercase">
                            <span>- Андрей Александров, Best Shop.</span>
                        </div>
                    </div>
                    <div class="single-testimonial black-text text-center">
                        <div class="testimonial-title">
                            <span class="icon-quote"></span>
                            <h3 class="black-text">Это взрыв!</h3>
                        </div>
                        <p><span>"</span>Я рад, что мы получили такой классный продукт на выходе!
                                         Думаю, что совместными усилиями мы реализуем ещё не один
                                         проект.<span>"</span></p>
                        <div class="testimonial-author text-uppercase">
                            <span>- Виталий Нохрин, NA'MAN Rec.</span>
                        </div>
                    </div>
                    <div class="single-testimonial black-text text-center">
                        <div class="testimonial-title">
                            <span class="icon-quote"></span>
                            <h3 class="black-text">Большая удача?</h3>
                        </div>
                        <p><span>"</span>Мы нашли WeCoders после десятка неудачных проектов с другими web студиями. И…
                                         Это большая удача, <span>"</span></p>
                        <div class="testimonial-author text-uppercase">
                            <span>- Ирина Граф, Cars & Cars company</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Футер -->
<footer class="footer-style-2">
    <div class="footer-top-area brand-bg pad-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="footer-widget footer-widget-center text-center">
                        <!-- Лого + текст -->
                        <div class="footer-logo">
                            <a href="#">
                                <img src="img/logo/logo-white.png" alt=""/>
                            </a>
                        </div>
                        <p>Если вы похожи на большинство компаний, у вас нет маркетингового бюджета в миллион
                           долларов<br>
                           или своей команды разработки. Но это не значит, что у вас не может быть<br>
                           сайта мирового класса. И мы вам в этом поможем!</p>

                        <!-- Соц. сети -->
                        <div class="social-icon">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- нижнее меню -->
    <div class="footer-bottom-area pad-20 brand-bg footer-border">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <div class="copyright white-text">
                        <p>We Coders © 2018</p>
                    </div>
                </div>

                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="footer-nav white-text">
                        <nav>
                            <ul>
                                <li class="mega-parent">
                                    <a href="index.html">Главная</a>
                                </li>
                                <li>
                                    <a href="about_us.html">О нас</a>
                                </li>
                                <li>
                                    <a href="services.html">Услуги</a>
                                </li>
                                <li>
                                    <a href="portfolio.html">Портфолио</a>
                                </li>
                                <li>
                                    <a href="blog.html">Блог</a>
                                </li>
                                <li>
                                    <a href="contacts.html">Контакты</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

        @endguest
    
@endsection
<style>
    #app {
        background: initial;
    }
</style>

