@extends('catalog.layout')

{{--@section('title', $content['title'])--}}
{{--@section('keywords', $content['keywords'])--}}
{{--@section('description', $content['description'])--}}

@section('content')

<!-- Start Body Content -->
<div id="content" class="content full" ng-app="myApp">
    <div class="container">
        <div class="text-align-center error-404">
            <h1 class="huge" style="color: lightgrey">404</h1>
            <hr class="sm">
            <p><strong>Извините, страница не найдена!</strong></p>
            <p>Запрашиваемая Вами страница была перемещена, удалена, переименована<br> или вероятно никогда не существовала.</p>
        </div>
        <div class="spacer-30"></div>
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