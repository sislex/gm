@extends('admin.layout')

@section('page_bar')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                Настройки
                <i class="fa fa-circle"></i>
                <a href="{{action('Admin\SettingsController@serviceFiles')}}" class="nav-link ">
                    Служебные файлы
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title">
        <small>Список служебных файлов</small>
    </h3>
    <!-- END PAGE TITLE-->

    <!-- BEGIN CONTENT BODY -->
    <div class="row">
        <div class="portlet-body col-xs-12 col-md-6">
            <div class="table-scrollable">
                {{-- @if(count($counters)) --}}
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> # </th>
                        <th> Название </th>
                        <th> Файл </th>
                        <th> Описание </th>
                        <th>
                            <a href="{{action('Admin\SettingsController@addServiceFile')}}" class="btn btn-outline btn-circle btn-sm green">
                                <i class="fa fa-plus"></i>
                                Добавить
                            </a>
                        </th>
                    </tr>
                    </thead>

                    @if(isset($serviceFiles) && count($serviceFiles))
                        <tbody>
                        @foreach($serviceFiles as $serviceFile)
                            <tr>
                                <td>{{$serviceFile['id']}}</td>
                                <td>{{$serviceFile['name']}}</td>
                                <td>{{$serviceFile['filename']}}</td>
                                <td>{{$serviceFile['description']}}</td>
                                <td>
                                    <a class="btn btn-outline btn-circle btn-sm red modal-del-confirm"
                                       data-toggle="modal"
                                       del-obj="Вы действительно хотите удалить счетчик '{{ $serviceFile['name'] }}' ?"
                                       del-url="{{action('Admin\SettingsController@deleteServiceFile', ['id' => $serviceFile['id']])}}" >
                                        <i class="fa fa-remove"></i>
                                        Удалить
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif

                </table>
                {{-- @endif --}}
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection