@extends('admin.layout')

@section('page_bar')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
               Настройки меню
                <i class="fa fa-circle"></i>
                <a href="{{action('Admin\SettingsController@counters')}}" class="nav-link ">
                    Калькулятор
                </a>
            </li>
        </ul>
    </div>
    @endsection

    @section('content')
            <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title">
        <small>Настройки калькулятора</small>
    </h3>
    <!-- END PAGE TITLE-->

    <!-- BEGIN CONTENT BODY -->
    <div class="row">
        <div class="portlet-body col-xs-12 col-md-6">
            <div class="table-scrollable">
                {{--            @if(count($counters))--}}
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Название </th>
                        <th> Значение </th>
                        <th>  </th>
                    </tr>
                    </thead>

                    @if(isset($counters) && count($counters))
                        <tbody>
                        @foreach($counters as $counter)
                            <tr>
                                <td>Процент</td>
                                <td>
                                    <input type="text" value="29.9">
                                </td>
                                <td>
                                    <input type="submit" value="Сохранить">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif

                </table>
                {{--@endif--}}
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection

@section('page_bar')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{action('Admin\ContentController@index')}}">Верхнее меню</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
    </div>
@endsection