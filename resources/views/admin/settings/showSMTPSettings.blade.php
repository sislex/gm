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
                <i class="fa fa-circle"></i>
                Изменить настройки SMTP аккаунта
            </li>
        </ul>
    </div>
    @endsection

    @section('content')
            <!-- BEGIN CONTENT BODY -->

    <!-- BEGIN NAV TAB -->
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab_0" data-toggle="tab"> Содержимое </a>
        </li>

    </ul>
    <!-- END NAV TAB -->

    <!-- BEGIN FORM-->
    <div class="row">
        <form id="smtp_form" action="{{action('Admin\SettingsController@updateSMTPSettings')}}" method="post" class="form-horizontal">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="id" id="id" value="{{ $smtp['id'] or '' }}" />

            <div class="tab-content">
                <div class="tab-pane active" id="tab_0">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa"></i> Почтовый аккаунт для отправки писем
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Login </label>
                                    <div class="col-md-7">
                                        <input required class="form-control input-circle" name="login" type="email" value="{{ $smtp['login'] or ''}}" placeholder="Введите логин (имя пользователя)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Password </label>
                                    <div class="col-md-7">
                                        <input required class="form-control input-circle" name="password" type="password" value="{{ $smtp['password'] or ''}}" placeholder="Введите пароль">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> SMTP Server </label>
                                    <div class="col-md-7">
                                        <input required class="form-control input-circle" name="server" type="text" value="{{ $smtp['server'] or ''}}" placeholder="Введите адрес SMTP сервера">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Port </label>
                                    <div class="col-md-7">
                                        <input required class="form-control input-circle" name="port" type="number" value="{{ $smtp['port'] or ''}}" placeholder="Введите порт SMTP сервера">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Security </label>
                                    <div class="col-md-7">
                                        <select required class="form-control input-circle" name="security" placeholder="Выберите тип шифрования соединения">
                                                <option value="ssl" {{ $smtp['security'] == 'ssl' || $smtp['security'] == '' ? 'selected' : '' }}> SSL </option>
                                                <option value="tls" {{ $smtp['security'] == 'tls' ? 'selected' : '' }}> TLS </option>
                                                <option value="none" {{ $smtp['security'] == 'none' ? 'selected' : '' }}> Нет </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Описание </label>
                                    <div class="col-md-7">
                                        <input required class="form-control input-circle" name="description" type="text" value="{{ $smtp['description'] or ''}}" placeholder="Добавьте описание для этой записи">
                                    </div>
                                </div>

                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn btn-circle green">Сохранить</button>
                                        <a href="{{action('Admin\SettingsController@email')}}" class="btn btn-circle red btn-outline">Отменить</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <!-- END FORM-->

    <!-- END CONTENT BODY -->
@endsection

@section('PAGE-LEVEL-PLUGINS')
    <script src="/admin/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/admin/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/admin/assets/global/plugins/bootstrap-summernote/summernote.js" type="text/javascript"></script>
@endsection

@section('PAGE-LEVEL-SCRIPTS')
    <script src="/admin/assets/pages/scripts/components-editors.js" type="text/javascript"></script>
@endsection

@section('PAGE-LEVEL-STYLES')
    <link href="/admin/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="/admin/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
@endsection
