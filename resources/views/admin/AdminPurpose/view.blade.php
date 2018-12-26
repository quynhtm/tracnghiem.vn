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
                            <div class="form-group col-lg-3">
                                <label><i>{{viewLanguage('Tên')}}</i></label>
                                <input type="text" class="form-control input-sm" name="purpose" placeholder="{{viewLanguage('Tên')}}" @if(isset($search['purpose']))value="{{$search['purpose']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                                <select name="status" id="status" class="form-control input-sm">
                                    {!! $optionSearch !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="status" class="control-label col-lg-12">&nbsp;</label>
                                @if($is_root || $permission_full || $permission_create)
                                    <a class="btn btn-danger btn-sm" href="{{URL::route('admin.purposeView')}}">
                                        <i class="ace-icon fa fa-plus-circle"></i>
                                        {{viewLanguage('Thêm mới')}}
                                    </a>
                                @endif
                                <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('Tìm kiếm')}}</button>
                            </div>
                        </div>
                    </form>
                    <div class="panel-body line" id="element">
                        <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                        <table class="table table-bordered bg-head-table">
                            <thead>
                            <tr>
                                {{--<th width="" class="text-center">{{viewLanguage('STT')}}</th>--}}
                                <th width="36%" >{{viewLanguage('Tên')}}</th>
                                <th width="40%">{{viewLanguage('Mô tả')}}</th>
                                <th width="12%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                                <th width="12%" class="text-center">{{viewLanguage('Hoạt động')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data) && sizeof($data))
                                @foreach($data as $k=>$item)
                                <tr>
                                    {{--<td class="text-center">{{$stt + $k + 1}}</td>--}}
                                    <td>{{$item->purpose}}</td>
                                    <td>{{$item->data}}</td>

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
                                            <a class="editItem" onclick="VM.editItem('{{$item->id}}', WEB_ROOT + '/manager/purpose/ajaxLoad')" title="{{viewLanguage('Sửa')}}">
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
                                <label for="name">{{viewLanguage('Tên')}} <span class="red"> (*) </span></label>
                                <input name="purpose" title="{{viewLanguage('Tên')}}" class="form-control input-required" id="name" type="text">
                            </div>
                            <div class="form-group">
                                <label for="name">{{viewLanguage('Mô tả')}} <span class="red"> (*) </span></label>
                                <textarea name="data" id="data" title="{{viewLanguage('Mô tả')}}" cols="30" rows="2" class="form-control input-required"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">{{viewLanguage('Trạng thái')}}</label>
                                <select class="form-control input-sm" name="status" id="status">
                                    {!! $optionStatus !!}
                                </select>
                            </div>
                            @if($is_root || $permission_full || $permission_create)
                            <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/purpose/post/0')">
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