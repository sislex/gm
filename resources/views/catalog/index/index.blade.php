@extends('catalog.layout')

@section('title', isset($mainpage['title']) ? $mainpage['title'] : '')
@section('keywords', isset($mainpage['keywords']) ? $mainpage['keywords'] : '')
@section('description', isset($mainpage['description']) ? $mainpage['description'] : '')

@section('content')
    <div id="divMyApp">

        <!-- Start Main Slider -->
        <div class="hero-area" ng-controller="lastCarsWidget">

            @if(isset($main_slider) && is_array($main_slider))
                @if((isset($main_slider['configuration']) && $main_slider['configuration'] == 'images' && isset($main_slider['images']) && count($main_slider['images']))
                || (!isset($main_slider['configuration']) && isset($main_slider['images']) && count($main_slider['images'])))
                    <div class="hero-slider heroflex flexslider clearfix" data-autoplay="yes" data-pagination="no" data-arrows="yes" data-style="fade" data-speed="7000" data-pause="yes">
                        <ul class="slides">
                            @foreach($main_slider['images'] as $main_slider_image)
                                <li class="parallax" style="background-image:url('/images/ui-components/main-slider/{{ $main_slider_image }}');"></li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(isset($main_slider['configuration']) && $main_slider['configuration'] == 'html' && isset($main_slider['html']) && trim($main_slider['html']) != '')
                    {!! $main_slider['html'] !!}
                @endif
            @endif

        </div>
        <!-- End Main Slider -->

        <!-- Utiity Bar -->
        <div class="utility-bar">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-8">
                        <div class="toggle-make">
                            <a href="#"><i class="fa fa-navicon"></i></a>
                            <span>Отсортировать по типу кузова</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="by-type-options">
                <div class="container">
                    <div class="row">
                        <ul class="owl-carousel carousel-alt" data-columns="6" data-autoplay="" data-pagination="no" data-arrows="yes" data-single-item="no" data-items-desktop="6" data-items-desktop-small="4" data-items-mobile="3" data-items-tablet="4">
                            <li class="item"> <a href='{{action('Catalog\CatalogController@index')}}#filter={"Тип кузова":{"0":{"text":"автобус"}}}'><img src="/catalog/images/body-types/wagon.png" alt=""> <span>Wagon</span></a></li>
                            <li class="item"> <a href="results-list.html"><img src="/catalog/images/body-types/minivan.png" alt=""> <span>Minivan</span></a></li>
                            <li class="item"> <a href="results-list.html"><img src="/catalog/images/body-types/coupe.png" alt=""> <span>Coupe</span></a></li>
                            <li class="item"> <a href="results-list.html"><img src="/catalog/images/body-types/convertible.png" alt=""> <span>Convertible</span></a></li>
                            <li class="item"> <a href="results-list.html"><img src="/catalog/images/body-types/crossover.png" alt=""> <span>Crossover</span></a></li>
                            <li class="item"> <a href="results-list.html"><img src="/catalog/images/body-types/suv.png" alt=""> <span>SUV</span></a></li>
                            <li class="item"> <a href="results-list.html#"><img src="/catalog/images/body-types/minicar.png" alt=""> <span>Minicar</span></a></li>
                            <li class="item"> <a href="results-list.html"><img src="/catalog/images/body-types/sedan.png" alt=""> <span>Sedan</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Body Content -->
        <div class="main" role="main">
            <div id="content" class="content full padding-b0">
                <div class="container">

                    <!-- Welcome Content and Services overview -->
                    @if(isset($mainpage['text']))
                        <div class="row">

                            {!! $mainpage['text'] !!}

                        </div>
                        <div class="spacer-75"></div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="uppercase strong">Welcome to AutoStars<br>Listing portal</h1>
                                <p class="lead">AutoStars is the world's leading portal for<br>easy and quick <span class="accent-color">car buying and selling</span></p>
                            </div>
                            <div class="col-md-6">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel. Donec vel mauris quam.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel. Donec vel mauris quam. Lorem ipsum dolor sit amet, <span class="accent-color">consectetur adipiscing</span> elit. Nulla convallis egestas rhoncus.</p>
                            </div>
                        </div>
                        <div class="spacer-75"></div>
                    @endif

                    <!-- Recently Listed Vehicles -->
                    <section class="listing-block recent-vehicles" ng-controller="lastCarsWidget" >
                        <div ng-if="(items.length>0)">
                            <div class="listing-header" >
                                <h3>Новые поступления</h3>
                            </div>
                            <div class="listing-container">
                                <div class="carousel-wrapper">
                                    <div class="row">
                                        <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="4" data-autoplay="" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="4" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1">
                                            <li class="item" ng-repeat="item in items">
                                                <div class="vehicle-block format-standard">
                                                    <a href="{{action('Catalog\CatalogController@item')}}/@{{ item.item['id'] }}" class="media-box">
                                                        <img ng-src="/images/items/@{{ item.item['id'] }}/thumbnail/@{{ item.images[0] }}" alt="">
                                                    </a>
                                                    <span class="label label-default vehicle-age">@{{ item['God_vypuska'][0]['text'] }}</span>
                                                    {{--<span class="label label-success premium-listing">Premium </span>--}}
                                                    <h5 class="vehicle-title"><a href="{{action('Catalog\CatalogController@item')}}/@{{ item.item['id'] }}">@{{ item.type_auto[0].children[0].text }} @{{ item.type_auto[0].children[0].children[0].text }} @{{ item['Версия/Модификация']  }} @{{ item.God_vypuska[0].text }}</a></h5>
                                                <span class="vehicle-meta">
                                                    @{{ item.type_auto[0].children[0].text }}, @{{ item['Цвет'][0]['text'] }}
                                                </span>
                                                    <span class="vehicle-cost pull-left">$@{{ item.item.price | ceil }}</span>
                                                    <span class="vehicle-cost pull-right">@{{ item.item.price * currencies.BYR | ceil }} <span style="font-size: 10px">руб</span>.</span>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="spacer-60"></div>

                    <!-- Latest News -->
                    <section class="listing-block latest-news" ng-controller="lastNewsWidget" ng-init="getLastNews(6)">
                        <div ng-if="news.length > 0">
                            <div class="listing-header">
                                <h3>
                                    Последние новости
                                </h3>
                            </div>
                            <div class="listing-container">
                                <div class="carousel-wrapper">
                                    <div class="row">
                                        <ul class="owl-carousel" id="news-slider" data-columns="3" data-autoplay="5000" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="3" data-items-desktop-small="1" data-items-tablet="3" data-items-mobile="1">

                                                <li class="item" ng-repeat="single_news in news">
                                                    <div class="post-block format-standard">
                                                        {{-- @{{ single_news['previewImageURL'] }} --}}
                                                        <a ng-if="single_news['previewImageURL']" href="{{ action('Catalog\CatalogController@news')}}/@{{ single_news['pseudo_url'] }}">
                                                            <img ng-src="@{{ single_news['previewImageURL'] }}" alt="" class="img-thumbnail">
                                                        </a>
                                                        <div class="post-actions">
                                                            <div class="post-date">
                                                                @{{ single_news['date'] }}
                                                            </div>
                                                        </div>
                                                        <h3 class="post-title">
                                                            <a href="{{ action('Catalog\CatalogController@news')}}/@{{ single_news['pseudo_url'] }}">
                                                                @{{ single_news['name'] }}
                                                            </a>
                                                        </h3>
                                                        <div class="post-content">
                                                            <p>
                                                                @{{ single_news['short_text'] }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="spacer-40"></div>

                    <!-- Feedbacks slider via AJAX -->
                    <div ng-controller="FeedbacksWidget">
                        <div ng-if="feedbacks && feedbacks.length > 0">
                            <section class="listing-block latest-testimonials">
                                <div class="listing-header">
                                    <h3> Отзывы клиентов </h3>
                                </div>
                                <div class="listing-container">
                                    <div class="carousel-wrapper">
                                        <div class="row">
                                            <ul class="owl-carousel carousel-fw" id="feedbacks-slider" data-columns="2" data-autoplay="5000" data-pagination="no" data-arrows="no" data-single-item="no" data-items-desktop="2" data-items-desktop-small="1" data-items-tablet="1" data-items-mobile="1">
                                                <li ng-repeat="feedback in feedbacks" class="item">
                                                    <div ng-if="feedback['name'] && feedback['name'] != '' && feedback['short_text'] && feedback['short_text'] != ''" class="testimonial-block">
                                                        <blockquote>
                                                            <p> @{{ feedback['short_text'] }} </p>
                                                        </blockquote>

                                                        <div ng-if="feedback['previewImageURL']" class="testimonial-avatar">
                                                            <img ng-src="@{{ feedback['previewImageURL'] }}" alt="Feedback Owner Photo" width="60" height="60">
                                                        </div>

                                                        <div class="testimonial-info">
                                                            <div class="testimonial-info-in">
                                                                <strong>@{{ feedback['name'] }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- End Feedbacks slider -->
                </div>

                <div class="spacer-50"></div>

                <!-- Partners slider via AJAX -->
                <div class="lgray-bg make-slider">
                    <div class="container">
                        <div ng-controller="PartnersWidget" class="row">
                            <div ng-if="partners['configuration'] == 'images' && partners['images'] && partners['images'].length > 0">
                                <div class="col-md-3 col-sm-4">
                                    <h3> Наши партнеры </h3>
                                </div>
                                <div class="col-md-9 col-sm-8">
                                    <div class="row">
                                        <ul class="owl-carousel" id="partners-slider" data-columns="5" data-autoplay="6000" data-pagination="no" data-arrows="no" data-single-item="no" data-items-desktop="5" data-items-desktop-small="4" data-items-tablet="3" data-items-mobile="3">
                                            <li ng-repeat="partner_image in partners['images']" class="item">
                                                <a ng-href="@{{ (partners['urls'][$index].trim() != '' && partners['urls'][$index].indexOf('http://') && partners['urls'][$index].indexOf('https://'))
                                                    ? 'http://' + partners['urls'][$index] : partners['urls'][$index]}}" target="_blank">
                                                    <img ng-src="/images/ui-components/partners-slider/@{{ partners['images'][$index] }}" alt="Partner Image">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div ng-if="partners['configuration'] == 'html' && partners['html'] && partners['html'].length > 0">
                                <div class="col-md-3 col-sm-4">
                                    <h3> Наши партнеры </h3>
                                </div>
                                <div class="col-md-9 col-sm-8">
                                    <div class="row">
                                        @{{ partners['html'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Partners slider -->

            </div>
        </div>
        <!-- End Body Content -->
    </div>
@endsection

@section('PAGE-LEVEL-PLUGINS')
    <script src="/admin/assets/global/plugins/angularjs/angular.min.js"></script>
    <script src="/admin/js/checklist-model.js" type="text/javascript"></script>
    <script src="/admin/assets/global/plugins/angularjs/angular-cookies.min.js"></script>
@endsection

@section('PAGE-LEVEL-SCRIPTS')
    <script src="/admin/js/items/item.js" type="text/javascript"></script>
    <script src="/catalog/js/index/widgets.js" type="text/javascript"></script>
    <script>
        setTimeout(function() {
            if (window.AUTOSTARS) {
                window.AUTOSTARS.OwlCarousel($('#feedbacks-slider, #partners-slider'));
            }
        }, 500);
    </script>

    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="/catalog/vendor/revslider/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="/catalog/vendor/revslider/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.tp-banner').show().revolution(
                    {
                        dottedOverlay:"none",
                        delay:9000,
                        startwidth:1170,
                        startheight:550,
                        hideThumbs:200,

                        thumbWidth:100,
                        thumbHeight:50,
                        thumbAmount:5,

                        navigationType:"none",
                        navigationArrows:"solo",
                        navigationStyle:"preview2",

                        touchenabled:"on",
                        onHoverStop:"on",

                        swipe_velocity: 0.7,
                        swipe_min_touches: 1,
                        swipe_max_touches: 1,
                        drag_block_vertical: false,


                        keyboardNavigation:"on",

                        navigationHAlign:"center",
                        navigationVAlign:"bottom",
                        navigationHOffset:0,
                        navigationVOffset:20,

                        soloArrowLeftHalign:"left",
                        soloArrowLeftValign:"center",
                        soloArrowLeftHOffset:20,
                        soloArrowLeftVOffset:0,

                        soloArrowRightHalign:"right",
                        soloArrowRightValign:"center",
                        soloArrowRightHOffset:20,
                        soloArrowRightVOffset:0,

                        shadow:0,
                        fullWidth:"on",
                        fullScreen:"off",

                        spinner:"spinner0",

                        stopLoop:"off",
                        stopAfterLoops:-1,
                        stopAtSlide:-1,

                        shuffle:"off",

                        autoHeight:"off",
                        forceFullWidth:"off",



                        hideThumbsOnMobile:"off",
                        hideNavDelayOnMobile:1500,
                        hideBulletsOnMobile:"off",
                        hideArrowsOnMobile:"off",
                        hideThumbsUnderResolution:0,

                        hideSliderAtLimit:0,
                        hideCaptionAtLimit:0,
                        hideAllCaptionAtLilmit:0,
                        startWithSlide:0
                    });
        });	//ready
    </script>

@endsection