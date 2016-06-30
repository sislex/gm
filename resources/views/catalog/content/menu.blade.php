@extends('catalog.layout')

@section('title', $content['title'])
@section('keywords', $content['keywords'])
@section('description', $content['description'])

@section('content')

<!-- Start Body Content -->
<div id="content" class="content full" ng-app="myApp">
    <div class="container">
        <div class="row">
            <div class="col-md-12 single-post">
                <article class="post-content">

                    {!! $content['text'] !!}

                </article>



                <div class="col-md-6  text-justify" ng-controller="myCtrl">
                    <div class="sidebar-widget widget seller-contact-widget">
                        <h4 class="widgettitle"> Заказать обратный звонок </h4>

                        <div class="vehicle-enquiry-in" id="callMeBackWidget" style="position: relative">
                            <input name="name" class="form-control" type="text" placeholder="Имя*" ng-model="mail.name">
                            <input name="email" class="form-control" type="email" placeholder="Email*" ng-model="mail.email">
                            <input name="phone" class="form-control" type="text" placeholder="Телефон №*" ng-model="mail.phone">
                            <textarea name="comment" class="form-control" placeholder="Комментарий" ng-model="mail.comment"></textarea>

                            <div >
                                <div>
                                    <select name="type" class="form-control input-circle" ng-model="obj.help.type_auto[0]" ng-options="item.text for item in filter['type_auto'] | orderBy:'text':false" ng-change="obj.helpers.makeObj('type_auto', 'sublist')">
                                        <option value="">Тип: любой</option>
                                    </select>
                                </div>


                                <div ng-show="obj.help.type_auto[0].children">
                                    <select name="mark" class="form-control input-circle" ng-model="obj.help.type_auto[1]" ng-options="item.text for item in obj.help['type_auto'][0].children | orderBy:'text':false" ng-change="obj.helpers.makeObj('type_auto', 'sublist')">
                                        <option value="">Марка: любая</option>
                                    </select>
                                </div>


                                <div ng-show="obj.help.type_auto[1].children">
                                    <select name="model" class="form-control input-circle" ng-model="obj.help.type_auto[2]" ng-options="item.text for item in obj.help['type_auto'][1].children | orderBy:'text':false" ng-change="obj.helpers.makeObj('type_auto', 'sublist')">
                                        <option value="">Модель</option>
                                    </select>
                                </div>

                                <div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="God_vypuska_min" class="form-control input-circle" ng-model="obj.help['God_vypuska']['min']" ng-options="item.text for item in filter['God_vypuska'] | orderBy:'text':true" ng-change="obj.helpers.makeObj('God_vypuska', 'value')" placeholder="Год от">
                                                <option value="">Год от:</option>
                                            </select>
                                        </div>

                                        <div class="form-group last-child">
                                            <select name="God_vypuska_max" class="form-control input-circle" ng-model="obj.help['God_vypuska']['max']" ng-options="item.text for item in filter['God_vypuska'] | orderBy:'text':true" ng-change="obj.helpers.makeObj('God_vypuska', 'value')" placeholder="Год до">
                                                <option value="">Год до</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>


                                <div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="price_min" class="form-control input-circle" ng-model="obj.help['price']['min']" ng-options="item for item in [1000,2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000, 12000, 14000, 16000, 18000, 20000, 25000, 30000, 45000, 50000, 100000]" ng-change="obj.helpers.makeObj('price', 'value')" placeholder="Цена от">
                                                <option value="">Цена от $:</option>
                                            </select>
                                        </div>

                                        <div class="form-group last-child">
                                            <select name="price_max" class="form-control input-circle" ng-model="obj.help['price']['max']" ng-options="item for item in [1000,2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000, 12000, 14000, 16000, 18000, 20000, 25000, 30000, 45000, 50000, 100000]" ng-change="obj.helpers.makeObj('price', 'value')" placeholder="Цена до">
                                                <option value="">До $: 200000</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>


                                <div class="accordion-group panel">
                                    <select name="engine" class="form-control input-circle" ng-model="obj.help['Тип двигателя'][0]" ng-options="item.text for item in filter['Тип двигателя'] | orderBy:'text':false" ng-change="obj.helpers.makeObj('Тип двигателя')">
                                        <option value="">Тип двигателя: любой</option>
                                    </select>
                                </div>


                                <div class="accordion-group panel">
                                    <select name="body" class="form-control input-circle" ng-model="obj.help['Тип кузова'][0]" ng-options="item.text for item in filter['Тип кузова'] | orderBy:'text':false" ng-change="obj.helpers.makeObj('Тип кузова')">
                                        <option value="">Тип кузова: любой</option>
                                    </select>
                                </div>


                                <div class="accordion-group panel">
                                    <select name="transmission" class="form-control input-circle" ng-model="obj.help['Трансмиссия'][0]" ng-options="item.text for item in filter['Трансмиссия'] | orderBy:'text':false" ng-change="obj.helpers.makeObj('Трансмиссия');">
                                        <option value="">Трансмиссия: любая</option>
                                    </select>
                                </div>

                            </div>



                            <input name="send" class="btn btn-primary" type="button" value="Перезвоните мне" ng-click="mail.send()">
                        </div>

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