@extends('catalog.layout')

@section('title', $item->title)
@section('description', $item->description)
@section('keywords', $item->keywords)



@section('content')
    <!-- Start Page header -->

    @if(isset($catalog_banner['images'][0]))
        <div class="page-header parallax" style="background-image:url('/images/ui-components/catalog-banner/{{ $catalog_banner['images'][0] }}');">
            {{--<div class="container">--}}
                {{--<h1 class="page-title">Listing results</h1>--}}
            {{--</div>--}}
        </div>
    @endif

    <!-- Utiity Bar -->
    <div class="utility-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                        <li><a href="/catalog/index"> Каталог </a></li>
                        <li class="active">
                            {{$item['name'] or ''}}
                        </li>
                    </ol>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-4">
                    <div class="ya-share2 pull-right" style="padding-top: 8px" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,viber,whatsapp"></div>
                    <span class="share-text pull-right" style="margin-right: 20px"><i class="icon-share"></i> Поделись </span>
                    <script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
                    <script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Body Content -->
    <div id="divMyApp" class="main" role="main"
         ng-controller="myCtrl"
         ng-init="obj.objJson={{json_encode($item['obj'])}}; obj.id={{$item['id']}}; obj.price={{$item['price']}}"
            >
        <div id="content" class="content full">
            <div class="container">
                <!-- Vehicle Details -->
                <article class="single-vehicle-details">
                    <div class="single-vehicle-title">

                        <span class="badge-premium-listing">№{{$item['id']}} добавлено: {{date('d-m-Y', strtotime($item['created_at']))}}</span>
                        <h1 class="post-title">
                            {{$item['name'] or ''}}
                        </h1>
                        <span class="viewed-count"><img src="/images/eye.svg" alt=""> Просмотров: {{ $item['views_count'] or '1' }}</span>

                    </div>
                    <div class="single-listing-actions">
                        <div class="btn-group pull-right" role="group">
                            <a ng-click="obj.helpers.addToWishList(obj.obj)" class="btn btn-default" title="Добавить в избранное">
                                <i class="fa fa-star-o" ng-if="!obj.helpers.checkId(wishList, obj.obj.id)"></i>
                                <i class="fa fa-star"  ng-if="obj.helpers.checkId(wishList, obj.obj.id)" style="color: #F5CF44"></i>
                                <span>В избранное</span>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#infoModal" class="btn btn-default" title="Запросить дополнительную информацию"><i class="fa fa-info"></i> <span>Запрос доп. инфо.</span></a>
                            <a href="#" data-toggle="modal" data-target="#testdriveModal" class="btn btn-default" title="Записаться на тест драйв"><i class="fa fa-calendar"></i> <span>Запись на тест драйв</span></a>
                            <a href="#" data-toggle="modal" data-target="#offerModal" class="btn btn-default" title="Предложить нам свою цену"><i class="fa fa-dollar"></i> <span>Предложить свою цену</span></a>
                            <a href="#" data-toggle="modal" data-target="#sendModal" class="btn btn-default" title="Поделиться ссылкой с другом"><i class="fa fa-send"></i> <span>Поделиться</span></a>
                            <a href="javascript:void(0)" onclick="window.print();" class="btn btn-default" title="Распечатать эту страницу"><i class="fa fa-print"></i> <span>Распечатать</span></a>
                        </div>
                        <div class="btn btn-info price" ng-cloak ng-if="(obj.obj.price * currencies.BYR) > 0">@{{ obj.obj.price * currencies.BYR | ceil }} <span style="font-size: 14px">руб</span>.</div>
                        <div class="btn btn-info price">${{ intval($item['price']) }}</div>

                        @if(isset($item['obj']['Старая цена']) && $item['obj']['Старая цена']!='')
                            <div class="btn btn-warning old-price">${{$item['obj']['Старая цена']}}</div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="single-listing-images">
                                <div class="featured-image format-image">
                                    @if(isset($item['images'][0]))
                                        @if(!file_exists('/images/items/'.$item['id'].'/'.$item['images'][0]))
                                        <a href="/images/items/{{ $item['id'] }}/{{ $item['images'][0] }}" data-rel="prettyPhoto[gallery]" class="media-box">
                                            <img src="/images/items/{{ $item['id'] }}/{{ $item['images'][0] }}" alt="Фотография 1 {{$item['name']}}">
                                        </a>
                                        @endif
                                    @endif
                                </div>
                                @if(isset($item['images']) && is_array($item['images']) && count($item['images']) > 1)
                                <div class="additional-images">
                                    <ul class="owl-carousel" id="images-slider" data-columns="4" data-pagination="no" data-arrows="yes" data-single-item="no" data-items-desktop="4" data-items-desktop-small="4" data-items-tablet="3" data-items-mobile="3">
                                        <?php $i = 1;?>
                                        @foreach($item['images'] as $key => $img)
                                            @if($key)
                                                <li class="item format-image">
                                                    <a href="/images/items/{{ $item['id'] }}/{{ $img }}" data-rel="prettyPhoto[gallery]" class="media-box">
                                                        <img src="/images/items/{{ $item['id'] }}/thumbnail/{{ $img }}" alt="Фотография {{++$i}} {{$item['name']}}">
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sidebar-widget widget">
                                <ul class="list-group">
                                    @if(isset($item['obj']['God_vypuska'][0]['text']))<li class="list-group-item"> <span class="badge">Год</span> {{$item['obj']['God_vypuska'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Тип кузова'][0]['text']))<li class="list-group-item"> <span class="badge">Кузов</span> {{$item['obj']['Тип кузова'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Probeg']))<li class="list-group-item"> <span class="badge">Пробег</span> {{$item['obj']['Probeg']}} km</li>@endif
                                    @if(isset($item['obj']['Трансмиссия'][0]['text']))<li class="list-group-item"> <span class="badge">Тип трансмиссии</span> {{$item['obj']['Трансмиссия'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Привод'][0]['text']))<li class="list-group-item"> <span class="badge">Привод</span> {{$item['obj']['Привод'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Состояние'][0]['text']))<li class="list-group-item"> <span class="badge">Состояние</span> {{$item['obj']['Состояние'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Цилиндров']))<li class="list-group-item"> <span class="badge">Цилиндры</span> {{$item['obj']['Цилиндров']}}</li>@endif
                                    @if(isset($item['obj']['Тип двигателя'][0]['text']))<li class="list-group-item"> <span class="badge">Двигатель</span> {{$item['obj']['Тип двигателя'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Объем куб. см.']))<li class="list-group-item"> <span class="badge">Объем куб. см.</span> {{$item['obj']['Объем куб. см.']}}</li>@endif
                                    @if(isset($item['obj']['Цвет']))<li class="list-group-item"> <span class="badge">Цвет</span> {{$item['obj']['Цвет'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Количество дверей'][0]['text']))<li class="list-group-item"> <span class="badge">Количество дверей</span> {{$item['obj']['Количество дверей'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['VIN']))<li class="list-group-item"> <span class="badge">VIN</span> {{$item['obj']['VIN']}}</li>@endif
                                    @if(isset($item['obj']['Класс транспорта'][0]['text']))<li class="list-group-item"> <span class="badge">Класс транспорта</span> {{$item['obj']['Класс транспорта'][0]['text']}}</li>@endif
                                    @if(isset($item['obj']['Обмен'][0]['text']))<li class="list-group-item"> <span class="badge">Обмен</span> {{$item['obj']['Обмен'][0]['text']}}</li>@endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="spacer-50"></div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="tabs vehicle-details-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"> <a data-toggle="tab" href="#vehicle-overview">Описание</a></li>
                                    <li> <a data-toggle="tab" href="#vehicle-specs">Тех. характеристики</a></li>
                                    <li> <a data-toggle="tab" href="#vehicle-add-features">Комплектация</a></li>
                                    <li> <a data-toggle="tab" href="#vehicle-location" class="mapButton">На карте</a> </li>
                                    @if(isset($item['obj']['video']))<li> <a data-toggle="tab" href="#vehicle-video">Видео</a> </li>@endif
                                </ul>
                                <div class="tab-content">
                                    <div id="vehicle-overview" class="tab-pane fade in active">
                                        {{$item['text']}}
                                    </div>
                                    <div id="vehicle-specs" class="tab-pane fade" ng-init="obj.specificationsJson='{{ $item['specifications'] or '' }}'">
                                        <div class="accordion" id="toggleArea">
                                            <div class="accordion-group panel"
                                                 ng-repeat="specificationGroup in specifications"
                                                 ng-if="obj.helpers.specificationsCheck(specificationGroup)"
                                                    >
                                                <div class="accordion-heading togglize"
                                                     ng-init="specificationGroup.minus=false"
                                                     ng-click="obj.helpers.trigger(specificationGroup, 'minus')">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#@{{ $index }}" href="#@{{ $index }}">
                                                        @{{ specificationGroup.name }}
                                                        <i data-toggle="collapse" data-parent="#@{{ $index }}" href="#@{{ $index }}"
                                                            ng-if="!specificationGroup.minus" class="fa fa-plus-circle"></i>
                                                        <i data-toggle="collapse" data-parent="#@{{ $index }}" href="#@{{ $index }}"
                                                            ng-if="specificationGroup.minus" style="display: block" class="fa fa-minus-circle"></i>
                                                    </a>
                                                </div>
                                                <div id="@{{ $index }}" class="accordion-body collapse">
                                                    <div class="accordion-inner">
                                                        <table class="table-specifications table table-striped table-hover">
                                                            <tbody>
                                                            <tr ng-repeat="child in specificationGroup.children" ng-if="obj.specifications[specificationGroup.name][child]">
                                                                <td>@{{ child }}</td>
                                                                <td>@{{ obj.specifications[specificationGroup.name][child] }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Toggle -->
                                    </div>
                                    <div id="vehicle-add-features" class="tab-pane fade">
                                       <div ng-repeat="key in ['Аудиооборудование', 'Интерьер и экстерьер', 'Оснащение', 'Противоугонная система', 'Системы безопасности', 'Электропакет']">
                                           <div ng-if="obj.help[key].length">
                                               <h4>@{{key}}</h4>
                                               <ul class="add-features-list">
                                                   <li ng-repeat="role in obj.help[key]">@{{role.text}}</li>
                                               </ul>
                                           </div>
                                       </div>
                                    </div>
                                    <div id="vehicle-location" class="tab-pane fade">
                                        @if(isset($item['obj']['Страна'][0]['text']))<li class="list-group-item"> <span class="badge">Страна</span> {{$item['obj']['Страна'][0]['text']}}</li>@endif
                                        @if(isset($item['obj']['Страна'][0]['children'][0]['text']))<li class="list-group-item"> <span class="badge">Город</span> {{$item['obj']['Страна'][0]['children'][0]['text']}}</li>@endif

                                            @if(isset($item['obj']['mapX']) && isset($item['obj']['mapY']))
                                                <div id="map" style="width: 100%; height: 400px"></div>
                                                {{--<iframe width="100%" height="300px" frameBorder="0" src="http://a.tiles.mapbox.com/v3/imicreation.map-zkcdvthf.html?secure#18/{{$item['obj']['mapX']}}/{{$item['obj']['mapY']}}"></iframe>--}}
                                            @endif
                                    </div>
                                    @if(isset($item['obj']['video']))
                                    <div id="vehicle-video" class="tab-pane fade">
                                        <iframe style="width: 100%; min-height: 350px" src="https://www.youtube.com/embed/{{$item['obj']['video']}}" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="spacer-50"></div>

                            <!-- Recently Listed Vehicles -->
                            <section class="listing-block recent-vehicles" ng-controller="lastCarsWidget" >
                                <div ng-if="(items.length>0)">
                                    <div class="listing-header" >
                                        <h3>Новые поступления</h3>
                                    </div>
                                    <div class="listing-container">
                                        <div class="carousel-wrapper">
                                            <div class="row">
                                                <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="3" data-autoplay="" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="3" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1">
                                                    <li class="item" ng-repeat="item in items">
                                                        <div class="vehicle-block format-standard">
                                                            <a href="{{action('Catalog\CatalogController@item')}}/@{{ item.item['id'] }}" class="media-box">
                                                                <img ng-src="/images/items/@{{ item.item['id'] }}/thumbnail/@{{ item.images[0] }}" alt="">

                                                                <span class="label label-default vehicle-age">@{{ item['God_vypuska'][0]['text'] }}</span>
                                                                <span ng-if="item.promo.hot > 0" class="label label-primary vehicle-hot"> Срочно </span>
                                                                <span ng-if="item.promo.new > 0" class="label label-success vehicle-new2"> Новое </span>
                                                                <span ng-if="item.promo.reserved > 0" class="label label-primary vehicle-reserved"> В резерве </span>
                                                            </a>

                                                            <h5 class="vehicle-title"><a href="{{action('Catalog\CatalogController@item')}}/@{{ item.item['id'] }}">@{{ item.type_auto[0].children[0].text }} @{{ item.type_auto[0].children[0].children[0].text }} @{{ item['Версия/Модификация'] }} @{{ item.God_vypuska[0].text }}</a></h5>
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

                        </div>

                        <!-- Vehicle Details Sidebar -->
                        <div class="col-md-4 vehicle-details-sidebar sidebar">

                            <!-- Vehicle Enquiry -->
                            <div class="sidebar-widget widget seller-contact-widget">
                                <h4 class="widgettitle"> Заказать обратный звонок </h4>
                                <div ng-controller="callMeBackWidget" style="position: relative" id="callMeBackWidget" class="vehicle-enquiry-in">

                                    <form ng-submit="callMeBack.send()">
                                        <input ng-model="callMeBack.name" name="name" type="text" placeholder="Имя" class="form-control" >
                                        <input ng-model="callMeBack.email" name="email" type="email" placeholder="Email" class="form-control" >
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input ng-model="callMeBack.phone" name="phone" type="tel" ng-trim="true" required placeholder="Телефон №*" class="form-control">
                                            </div>
                                        </div>
                                        <textarea ng-model="callMeBack.comment" name="comment" class="form-control" placeholder="Комментарий"></textarea>
                                        {{--<label class="checkbox-inline">--}}
                                        {{--<input ng-model="callMeBack.subscribe" name="subscribe" type="checkbox" id="inlineCheckbox2" value="false"> Подписаться на новости--}}
                                        {{--</label>--}}


                                        <input name="send" type="submit" class="btn btn-primary" value="Перезвоните мне">
                                    </form>

                                </div>
                                {{--<div class="vehicle-enquiry-foot">--}}
                                    {{--<span class="vehicle-enquiry-foot-ico"><i class="fa fa-phone"></i></span>--}}
                                    {{--<strong>1800 011 2211</strong>Seller: <a href="#">Carcheck Sellers</a>--}}
                                {{--</div>--}}

{{--                                @if(\App\Phones::where('type','=','мобильный телефон')->first())--}}
                                    <div class="vehicle-enquiry-foot">
                                        @if(isset($item['obj']['телефон'][0]['text']))
                                        <span>
                                            <i class="fa fa-phone" style="font-size: medium"></i>
                                            <strong>
                                            {{--<a href="tel://{{ \App\Phones::where('type','=','мобильный телефон')->first()->value('phone') }}">--}}
                                                {{--{{ \App\Phones::where('type','=','мобильный телефон')->first()->value('phone') }}--}}
                                            {{--</a>--}}

                                                {{--<a href="tel://{{$item['obj']['телефон'][0]['text']}}"> {{$item['obj']['телефон'][0]['text']}} </a>--}}
                                                <a href="tel:{{$item['obj']['телефон'][0]['text']}}"> {{$item['obj']['телефон'][0]['text']}} </a>
                                            </strong>
                                        </span>
                                        <br>
                                        @endif

                                        <span>
                                            @if(isset($item['obj']['телефон 2'][0]['text']))
                                            <i class="fa fa-phone" style="font-size: medium"></i>
                                            <strong>
                                                {{--<a href="tel://{{$item['obj']['телефон 2'][0]['text']}}"> {{$item['obj']['телефон 2'][0]['text']}} </a>--}}
                                                <a href="tel:{{$item['obj']['телефон 2'][0]['text']}}"> {{$item['obj']['телефон 2'][0]['text']}} </a>
                                            </strong>
                                            @endif
                                            Продавец: Голденмоторс
                                        </span>
                                    </div>
                                {{--@endif--}}

                            </div>

                            <!-- Subscribe widget -->
                            <div class="sidebar-widget widget seller-contact-widget">
                                <h4 class="widgettitle" style="font-size: 11px;"> Хотите быть в курсе новых поступлений? Подпишись на рассылку! </h4>
                                <div ng-controller="subscribeWidget" style="position: relative" id="subscribeWidget" class="vehicle-enquiry-in">
                                    <form ng-submit="subscribe.send()" id="subscribe_form">
                                        <input ng-model="subscribe.name" name="name" type="text" placeholder="Имя" class="form-control">
                                        <input ng-model="subscribe.email" name="email" type="email" placeholder="Email*" class="form-control" required>
                                        <input name="send" type="submit" class="btn btn-primary" value="Подписаться">
                                    </form>

                                </div>
                            </div>

                            <br>

                            <!-- Financing Calculator -->
                            <div class="sidebar-widget widget calculator-widget">
                                <h4>Расчитать кредит</h4>
                                <form>
                                    <div class="loan-calculations"  ng-init="
                                    price = {{$item['price']}};
                                    downPayment = 0;
                                    month = 24;
                                    percent = {{$percent}};
                                    ">
                                        <div class="form-group">
                                            <label>Первоначальный взнос</label>
                                            <input type="text" class="form-control"  ng-model="downPayment" placeholder="Введите первоночальный взнос">

                                            <label>Сумма займа</label>
                                            <input type="text" class="form-control" placeholder="Введите сумму займа" ng-value="price - downPayment">

                                            <div class="hidden">
                                                <label>Процентная ставка</label>
                                                <input type="text" class="form-control" ng-model="percent" placeholder="Введите процентную ставку">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Количество месяцев</label>
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-info active" ng-click="month=24">
                                                    <input type="radio" name="Loan Tenure" id="option1" autocomplete="off" checked> 24
                                                    <input type="radio" ng-model="color.name" value="red">
                                                </label>
                                                <label class="btn btn-info" ng-click="month=36">
                                                    <input type="radio" name="Loan Tenure" ng-model="color.name" value="red" id="option2" autocomplete="off"> 36
                                                    <input type="radio" ng-model="color.name" value="blue">
                                                </label>
                                                <label class="btn btn-info" ng-click="month=48">
                                                    <input type="radio" name="Loan Tenure" id="option3" autocomplete="off"> 48
                                                </label>
                                                <label class="btn btn-info" ng-click="month=60">
                                                    <input type="radio" name="Loan Tenure" id="option3" autocomplete="off"> 60
                                                </label>
                                                <label class="btn btn-info" ng-click="month=72">
                                                    <input type="radio" name="Loan Tenure" id="option3" autocomplete="off"> 72
                                                </label>
                                                <label class="btn btn-info" ng-click="month=84">
                                                    <input type="radio" name="Loan Tenure" id="option3" autocomplete="off"> 84
                                                </label>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="calculations-result">
                                        <span class="meta-data">Выплата</span>
                                    <span class="loan-amount">
                                        {{--<span ng-if="((((price - downPayment) * (month/12) * percent/100) + (price - downPayment))/month)>0">--}}
                                            {{--$@{{ ((((price - downPayment) * (month/12) * percent/100) + (price - downPayment))/month) | ceil }}--}}
                                        {{--</span>--}}
                                        <span ng-if="(calc(price - downPayment, percent, month))>0">
                                            $@{{ calc(price - downPayment, percent, month) }}
                                        </span>
                                        <span ng-if="(calc(price - downPayment, percent, month))<=0">$0</span>

                                        <small>/месяц</small>
                                    </span>
                                    </div>
                                </form>
                            </div>

                            <div class="vehicle-enquiry-foot widget">
                                <span>
                                    <i class="fa fa-phone" style="font-size: medium"></i>
                                    <strong>
                                        {{--<a href="tel://+375447832832"> +375-(44)-7-832-832 </a>--}}
                                        <a href="tel:+375447832832"> +375-(44)-7-832-832 </a>
                                    </strong>
                                    Кредитный консультант
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- End Body Content -->
@endsection

@section('MODAL-PAGES')
    <div id="divMailApp" ng-controller="mailWidget">
        <!-- REQUEST MORE INFO POPUP -->
        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Запросить дополнительную информацию</h4>
                    </div>
                    <div class="modal-body">
                        <p>Запросить дополнительную информацию у специалиста компании.</p>
                        <form ng-submit="infoModal.send()">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input ng-model="infoModal.name" type="text" class="form-control" name="name" placeholder="Имя">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input ng-model="infoModal.email" type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input required ng-model="infoModal.phone" type="text" class="form-control" name="phone" placeholder="Телефон">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary pull-right" name="action" value="Запросить информацию">
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAKE AN OFFER POPUP -->
        <div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Сделать предложение</h4>
                    </div>
                    <div class="modal-body">
                        <p>Предложить свою цену, другие условия по преобретению или обмену.</p>
                        <form ng-submit="offerModal.send()">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input ng-model="offerModal.name" type="text" class="form-control" name="name" placeholder="Имя">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input ng-model="offerModal.email" type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input required ng-model="offerModal.phone" type="text" class="form-control" name="phone" placeholder="Телефон">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                        <input ng-model="offerModal.price" type="text" class="form-control" name="price" placeholder="Своя цена">
                                    </div>
                                </div>
                            </div>
                            <textarea ng-model="offerModal.comment" class="form-control" placeholder="Комментарий"></textarea>
                            <input type="submit" class="btn btn-primary pull-right" name="action" value="Предложить">
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- BOOK TEST DRIVE POPUP -->
        <div class="modal fade" id="testdriveModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Записаться на тестдрайв</h4>
                    </div>
                    <div class="modal-body">
                        <p>Запишитесь на тестдрайв</p>
                        <form ng-submit="testdriveModal.send()">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input ng-model="testdriveModal.name" type="text" class="form-control" name="name" placeholder="Имя">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input ng-model="testdriveModal.email" type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input required ng-model="testdriveModal.phone" type="text" class="form-control" name="phone" placeholder="Телефон">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input ng-model="testdriveModal.date" type="text" id="datepicker" class="form-control" name="date" placeholder="Желаемая дата">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-append bootstrap-timepicker">
                                        <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                        <input ng-model="testdriveModal.time" type="text" id="timepicker" class="form-control" name="time" placeholder="Желаемое время">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary pull-right" name="action" value="Записаться">
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEND TO A FRIEND POPUP -->
        <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Поделиться ссылкой</h4>
                    </div>
                    <div class="modal-body">
                        <form ng-submit="sendModal.send()">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input required ng-model="sendModal.name" type="text" class="form-control" name="name" placeholder="Имя">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input required ng-model="sendModal.email" type="email" class="form-control" name="email" placeholder="Ваш Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input required ng-model="sendModal.friend" type="email" class="form-control" name="friend" placeholder="Email друга">
                                    </div>
                                </div>
                            </div>
                            <textarea ng-model="sendModal.message" class="form-control" name="message" placeholder="Сообщение"></textarea>
                            <input type="submit" class="btn btn-primary pull-right" name="action" value="Отправить">
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                window.AUTOSTARS.OwlCarousel($('#images-slider'));
                AUTOSTARS.PrettyPhoto($(".single-listing-images a[data-rel^='prettyPhoto']"));
            }
        }, 500);
    </script>
    @if(isset($item['obj']['mapX']) && isset($item['obj']['mapY']))
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        $('.mapButton').bind('click', function(){

            ymaps.ready(init);
            var myMap,
                    myPlacemark;

            function init(){
                myMap = new ymaps.Map("map", {
                    center: [{{$item['obj']['mapX']}}, {{$item['obj']['mapY']}}],
                    zoom: 15
                });

                myPlacemark = new ymaps.Placemark([{{$item['obj']['mapX']}}, {{$item['obj']['mapY']}}], {
                });

                myMap.geoObjects.add(myPlacemark);
            }
        });

    </script>
    @endif
    <!--виджет расчета лизинговой схемы-->
    <script type="text/javascript" src="http://cln.by/static/js/informers/cln_goldenmotors_by.js"></script>
    <!-- -->
@endsection

