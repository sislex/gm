@extends('catalog.layout')

@section('title', $content['title'])
@section('keywords', $content['keywords'])
@section('description', $content['description'])

@section('content')
    <!-- Start Body Content -->
    <div id="content" class="content full" ng-app="myApp">
        <div class="container">
            <div class="row">
                <div class="col-md-9 single-post utility-bar">
                    <header class="single-post-header clearfix">
                        <div class="post-actions">
                            {{--<div class="post-date col-md-2 col-sm-2 col-xs-2">--}}
                            <div class="col-xs-3" style="line-height: 40px">
                                {{--November 27, 2014--}}
                                {{ date('d-m-Y', strtotime($content['created_at'])) }}
                            </div>
                            <div class="col-xs-9">

                                <div class="ya-share2 pull-right" style="padding-top: 8px" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,viber,whatsapp"></div>
                                <span class="share-text pull-right" style="margin-right: 20px"><i class="icon-share"></i> Поделись </span>

                                <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
                                <script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>

                            </div>
                        </div>
                        <h1 class="post-title">
                            {{ $content['name'] }}
                        </h1>
                    </header>

                    <article class="post-content">

                        {!! $content['text'] !!}

                    </article>

                </div>

                <!-- Start Sidebar -->
                <div class="col-md-3 sidebar">

                    @if(isset($categories))
                        <div class="widget sidebar-widget widget_categories">
                            <h3 class="widgettitle">
                                Категории
                            </h3>
                            <ul>
                                @foreach($categories as $category)
                                    @if($category['published'])
                                        <li>
                                            <a href="{{ action('Catalog\CatalogController@blog_category', ['pseudo_url' => $category['pseudo_url']]) }}">{{ $category['menu'] }}</a> &nbsp;
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="sidebar-widget widget seller-contact-widget">
                        <h4 class="widgettitle" style="font-size: 11px;"> Хотите быть в курсе наших новостей и скидок? Подпишитесь на рассылку! </h4>
                        <div ng-controller="subscribeWidget" style="position: relative" id="subscribeWidget" class="vehicle-enquiry-in">

                            <form ng-sumit="subscribe.send()" id="subscribe_form">
                                <input ng-model="subscribe.name" name="name" type="text" placeholder="Имя" class="form-control">
                                <input ng-model="subscribe.email" name="email" type="email" placeholder="Email*" class="form-control" required>
                                <input name="send" type="button" class="btn btn-primary" value="Подписаться">
                            </form>

                        </div>
                    </div>

                    <br>

                    <div class="widget sidebar-widget widget_recent_posts" ng-controller="lastBlogPostsWidget">

                        <div ng-if="blog.length > 0">
                            <h3 class="widgettitle">
                                Последние посты
                            </h3>
                            <ul>
                                <li class="" ng-repeat="blog_post in blog | orderBy: id">
                                    <a href="{{ action('Catalog\CatalogController@blog')}}/@{{ blog_post['pseudo_url'] }}">
                                        <img src="@{{ blog_post['previewImageURL'] }}" alt="" class="img-thumbnail">
                                    </a>
                                    <h5>
                                        <a href="{{ action('Catalog\CatalogController@blog')}}/@{{ blog_post['pseudo_url'] }}">
                                            @{{ blog_post['name'] }}
                                        </a>
                                    </h5>
                                    <div class="post-actions">
                                        <div class="post-date">
                                            @{{ blog_post['date'] }}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Body Content -->
@endsection

@section('PAGE-LEVEL-PLUGINS')
    <script src="/admin/assets/global/plugins/angularjs/angular.min.js" type="text/javascript"></script>
    <script src="/admin/js/checklist-model.js" type="text/javascript"></script>
    <script src="/admin/assets/global/plugins/angularjs/angular-cookies.min.js" type="text/javascript"></script>
@endsection

@section('PAGE-LEVEL-SCRIPTS')
    <script src="/catalog/js/catalog/index.js" type="text/javascript"></script>
    <script src="/catalog/js/index/widgets.js" type="text/javascript"></script>
@endsection