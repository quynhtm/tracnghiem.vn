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
            <div class="col-md-9 panel-content">
                <div class="panel panel-primary">
                    <div class="panel-heading paddingTop1 paddingBottom1">
                        <h4><i class="fa fa-list" aria-hidden="true"></i> {{$pageAdminTitle}}</h4>
                    </div>
                    <form method="get" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label><i>{{viewLanguage('Tên')}}</i></label>
                                <input type="text" class="form-control input-sm" name="define_name" placeholder="{{viewLanguage('Tên')}}" @if(isset($search['define_name']))value="{{$search['define_name']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="define_status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                                <select name="define_status" id="define_status" class="form-control input-sm">
                                    {!! $optionSearchStatus !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="define_type" class="control-label">{{viewLanguage('Loại định nghĩa')}}</label>
                                <select name="define_type" id="define_type" class="form-control input-sm">
                                    {!! $optionSearchType !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="define_status" class="control-label col-lg-12">&nbsp;</label>
                                <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('Tìm kiếm')}}</button>
                            </div>
                        </div>
                    </form>
                    <div class="panel line marginTop5" id="element">
                        <div class="span clearfix">&nbsp;&nbsp;&nbsp;&nbsp; @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                        <table class="table table-bordered bg-head-table">
                            <thead>
                            <tr>
                                {{--<th class="text-center" width="5%">{{viewLanguage('STT')}}</th>--}}
                                <th width="40%">{{viewLanguage('Thông tin định nghĩa')}}</th>
                                <th width="30%">{{viewLanguage('Mô tả')}}</th>
                                <th width="5%" class="text-center">{{viewLanguage('TT')}}</th>
                                <th width="10%" class="text-center">{{viewLanguage('Status')}}</th>
                                <th width="10%" class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data) && sizeof($data))
                                @foreach($data as $k=>$item)
                                <tr>
                                    {{--<td class="text-center">{{$stt + $k + 1}}</td>--}}
                                    <td>
                                        <b>[{{$item->id}}] {{$item->define_name}}</b>
                                        <br/>Mã: {{$item->define_code}}
                                    </td>
                                    <td>
                                        {{$item->define_note}}
                                    </td>
                                    <td class="text-center">{{$item->define_order}}</td>

                                    @php
                                        $style_background = '';
                                        $style_text = '';
                                        if(isset(CGlobal::$array_color_billExoenditure_status[$item['define_status']])){
                                            $style_background = CGlobal::$array_color_billExoenditure_status[$item['define_status']]['background'];
                                            $style_text = CGlobal::$array_color_billExoenditure_status[$item['define_status']]['text'];
                                        }
                                    @endphp
                                    <td class="text-center middle {{$style_background}}" data-container="body" data-toggle="popover" data-placement="top" data-title="{{viewLanguage('Thông tin log thao tác')}}" data-html-content="#popover{{$item->id}}">
                                        <a href="javascript:void(0);" title="Thành công" class="{{$style_text}}" ><span>{{isset($arrStatus[$item['define_status']]) ? $arrStatus[$item['define_status']] : ''}}</span></a>
                                        <div class="hidden popover-html" id="popover{{$item['id']}}">
                                            <div class="content">
                                                <table>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Người tạo")}}:</strong></td>
                                                        <td>{{$item->user_name_creater}} - {{$item->created_at}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Người cập nhật")}}:</strong></td>
                                                        <td>{{$item->user_name_update}} - {{$item->updated_at}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center middle" align="center">
                                        @if($is_root || $permission_full || $permission_create)
                                            <a class="editItem" onclick="VM.editItem('{{$item->id}}', WEB_ROOT + '/manager/define/ajaxLoad')" title="{{viewLanguage('Sửa')}}">
                                                <i class="fa fa-edit fa-2x"></i>
                                            </a>
                                        @endif
                                        @if($is_boss)
                                            <a href="javascript:void(0);" onclick="VM.deleteItem('{{$item->id}}', WEB_ROOT + '/manager/define/delete')" title="{{viewLanguage('Xóa')}}">
                                                <i class="fa fa-trash fa-2x"></i>
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
            <div class="col-md-3 panel-content loadForm">
                <div class="panel panel-primary">
                    <div class="panel-heading paddingTop1 paddingBottom1">
                        <h4>
                            <i class="fa fa-edit icChage" aria-hidden="true"></i> <span class="frmHead">{{viewLanguage('Thêm mới')}}</span>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form id="formAdd" method="post">
                            <input name="id_hiden" value="0" class="form-control" id="id_hiden" type="hidden">
                            <div class="form-group col-lg-12">
                                <label for="define_type">{{viewLanguage('Loại định nghĩa')}}</label>
                                <select class="form-control input-sm" name="define_type" id="define_type">
                                    {!! $optionDefineType !!}
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="define_name">{{viewLanguage('Tên')}} <span class="red"> (*) </span></label>
                                <input name="define_name"  id="define_name" title="{{viewLanguage('Tên tình trạng')}}" class="form-control input-required"type="text">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="define_name">{{viewLanguage('Mã code')}}</label>
                                <input name="define_code"  id="define_code"title="{{viewLanguage('Mã code')}}" class="form-control" type="text">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="define_name">{{viewLanguage('Mô tả')}} <span class="red"> (*) </span></label>
                                <textarea name="define_note" id="define_note" cols="30" rows="2" title="{{viewLanguage('Mô tả')}}" class="form-control input-required" id="define_name"></textarea>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="define_status">{{viewLanguage('Thứ tự')}}</label>
                                <input name="define_order"  id="define_order" title="{{viewLanguage('Thứ tự')}}" class="form-control"type="text" value="1">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="define_status">{{viewLanguage('Trạng thái')}}</label>
                                <select class="form-control input-sm" name="define_status" id="define_status">
                                    {!! $optionStatus !!}
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-12">
                                @if($is_root || $permission_full || $permission_create)
                                <a class="btn btn-success" id="submit" onclick="VM.addItem('form#formAdd', 'form#formAdd :input', '#submit', WEB_ROOT + '/manager/define/post/0')">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> {{viewLanguage('Lưu')}}
                                </a>
                                @endif
                                <a class="btn btn-default" id="cancel" onclick="VM.resetItem('#id_hiden', '0')">
                                    <i class="fa fa-undo" aria-hidden="true"></i> {{viewLanguage('Làm lại')}}
                                </a>
                            </div>
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