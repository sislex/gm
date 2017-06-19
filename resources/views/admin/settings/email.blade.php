@extends('admin.layout')

@section('page_bar')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                Настройки
                <i class="fa fa-circle"></i>
                <a href="{{action('Admin\SettingsController@email')}}" class="nav-link ">
                    Email
                </a>
            </li>
        </ul>
    </div>
    @endsection

    @section('content')
            <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title">
        Email
        <small> Конфигурация почты </small>
    </h3>
    <!-- END PAGE TITLE-->

    <!-- BEGIN CONTENT BODY -->
    <div class="portlet-body col-xs-12 col-md-9">
        <!-- BEGIN FORM -->
        <div class="row">
            <div class="panel-heading">
                <h4 class="panel-title"> Адрес, куда будут приходить письма с сайта </h4>
            </div>
            <div class="table-scrollable">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Contact email </th>
                        <th>  </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td> {{ $email['email'] or '' }} </td>
                        <td>
                            @if ($email['id'])
                                <a href="{{action('Admin\SettingsController@showEmail', ['id' => $email['id']])}}" class="btn btn-outline btn-circle btn-sm purple">
                                    <i class="fa fa-edit"></i>
                                    Редактировать
                                </a>
                            @else
                                <a href="{{action('Admin\SettingsController@showEmail', ['id' => ''])}}" class="btn btn-outline btn-circle btn-sm green">
                                    <i class="fa fa-plus"></i>
                                    Добавить
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="panel-heading">
                <h4 class="panel-title"> Настройка почтового аккаунта, используемого для отправки писем </h4>
            </div>
            <div class="table-scrollable">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Login </th>
                        <th> Password </th>
                        <th> SMTP Server </th>
                        <th> Port </th>
                        <th> Security </th>
                        <th> Описание </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{ $smtp['login'] or ''}} </td>
                            <td type="password"> {{ $smtp['password'] or '' }} </td>
                            <td> {{ $smtp['server'] or '' }} </td>
                            <td> {{ $smtp['port'] or '' }} </td>
                            <td> {{ $smtp['security'] or '' }} </td>
                            <td> {{ $smtp['description'] or '' }} </td>
                            <td>
                                @if ($smtp['id'])
                                    <a href="{{action('Admin\SettingsController@showSMTPSettings', ['id' => $smtp['id']])}}" class="btn btn-outline btn-circle btn-sm purple">
                                        <i class="fa fa-edit"></i> Редактировать
                                    </a>
                                @else
                                    <a href="{{action('Admin\SettingsController@showSMTPSettings', ['id' => ''])}}" class="btn btn-outline btn-circle btn-sm green">
                                        <i class="fa fa-plus"></i> Добавить
                                    </a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection