<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<?php use App\Library\AdminFunction\CGlobal; ?>

@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">{{viewLanguage('Trang chủ')}}</a>
            </li>
            <li class="active">{{$pageAdminTitle}}</li>
        </ul>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-8 panel-content">
                <div class="panel panel-primary">
                    <div class="panel-heading paddingTop1 paddingBottom1">
                        <h4><i class="fa fa-list" aria-hidden="true"></i> {{$pageAdminTitle}}</h4>
                    </div>
                    <form method="get" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-6">
                                <label for="status" class="control-label col-lg-12">&nbsp;</label>
                                @if($is_root || $permission_full || $permission_create)
                                    <a class="btn btn-danger btn-sm" href="{{URL::route('admin.versionAppView')}}">
                                        <i class="ace-icon fa fa-plus-circle"></i>
                                        {{viewLanguage('Thêm mới')}}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="panel-body line" id="element">
                        <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                        <table class="table table-bordered bg-head-table">
                            <thead>
                            <tr>
                                {{--<th width="" class="text-center">{{viewLanguage('STT')}}</th>--}}
                                <th width="28%" >{{viewLanguage('Kiểu')}}</th>
                                <th width="28%" >{{viewLanguage('Version')}}</th>
                                <th width="20%">{{viewLanguage('Bảo trì')}}</th>
                                <th width="12%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                                <th width="12%" class="text-center">{{viewLanguage('Hoạt động')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data) && sizeof($data))
                                @foreach($data as $k=>$item)
                                <tr>
                                    {{--<td class="text-center">{{$stt + $k + 1}}</td>--}}
                                    <td>{{\App\Http\Models\Admin\VersionApp::$array_os_type[$item->os_type]}}</td>
                                    <td>{{$item->version}}</td>
                                    <td>{{\App\Http\Models\Admin\VersionApp::$maintance[$item->is_mainten]}}</td>

                                    @if($item->status == STATUS_SHOW)
                                    <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['background']}}@endif">
                                        <a href="javascript:void(0);" title="Kích hoạt" class="@if(isset(CGlobal::$array_color_status[STATUS_SHOW] )) {{CGlobal::$array_color_status[STATUS_SHOW]['text']}}@endif" ><span>Kích hoạt</span></a>
                                    </td>
                                    @else
                                    <td class="text-center middle @if(isset(CGlobal::$array_color_status[STATUS_STOP] )) {{CGlobal::$array_color_status[STATUS_STOP]['background']}}@endif">
                                        <a href="javascript:void(0);" title="Khóa" class="@if(isset(CGlobal::$array_color_status[STATUS_STOP] )) {{CGlobal::$array_color_status[STATUS_STOP]['text']}}@endif" ><span>Khóa</span></a>
                                    </td>
                                    @endif

                                    <td class="text-center middle" align="center">
                                        @if($is_root || $permission_full || $permission_create)
                                            <a class="editItem" onclick="VM.editItem('{{$item->id}}', WEB_ROOT + '/manager/version_app/ajaxLoad')" title="{{viewLanguage('Sửa')}}">
                                                <i class="fa fa-edit fa-2x"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {!! $paging !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4 panel-content loadForm">
                <div class="panel panel-primary">
                    <div class="panel-heading paddingTop1 paddingBottom1">
                        <h4>
                            <i class="fa fa-edit icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Thêm mới')}}</span>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form id="formAdd" method="post">
                            <input name="id_hiden" value="0" class="form-control" id="id_hiden" type="hidden">
                            <div class="form-group">
                                <label for="status">{{viewLanguage('Type')}}</label>
                                <select class="form-control input-sm" name="type" id="type">
                                    {!! $optionType !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">{{viewLanguage('OS Type')}}</label>
                                <select class="form-control input-sm" name="os_type" id="os_type">
                                    {!! $optionOSType !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">{{viewLanguage('Maintenance')}}</label>
                                <select class="form-control input-sm" name="is_mainten" id="is_mainten">
                                    {!! $optionMaintenance !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">{{viewLanguage('Version')}}<span class="red"> (*) </span></label>
                                <input name="version" title="{{viewLanguage('Version')}}" placeholder="VD: 3.3.12" class="form-control input-required" id="version" type="text">
                            </div>
                            <div class="form-group">
                                <label for="status">{{viewLanguage('Trạng thái')}}</label>
                                <select class="form-control input-sm" name="status" id="status">
                                    {!! $optionStatus !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="data">{{viewLanguage('Message')}}<span class="red"> (*) </span></label>
                                <textarea name="message" id="message" title="{{viewLanguage('Message')}}" cols="30" rows="2" class="form-control input-required"></textarea>
                            </div>
                            @if($is_root || $permission_full || $permission_create)
                            <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/version_app/post/0')">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{viewLanguage('Lưu')}}
                            </a>
                            @endif
                            <a class="btn btn-default" id="cancel" onclick="VM.resetItem('#id_hiden', '0')">
                                <i class="fa fa-undo" aria-hidden="true"></i> {{viewLanguage('Làm lại')}}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        VM.scrolleTop();
    });
</script>
@stop