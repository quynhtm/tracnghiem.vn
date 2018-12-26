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
            <div class="col-md-12 panel-content">
                <div class="panel panel-primary">
                    <div class="panel-heading paddingTop1 paddingBottom1">
                        <h4><i class="fa fa-list" aria-hidden="true"></i> {{$pageAdminTitle}}</h4>
                    </div>
                    <form method="post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label><b>{{viewLanguage('Tên thuộc tính')}}</b></label>
                                <input type="text" class="form-control input-sm" name="name" placeholder="{{viewLanguage('Tên thuộc tính')}}" @if(isset($search['name']))value="{{$search['name']}}"@endif>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="status" class="control-label col-lg-12">&nbsp;</label>
                                @if($is_root || $permission_full || $permission_create)
                                    <a class="btn btn-danger btn-sm" href="{{URL::route('admin.documentEntityAttributeEdit',array('id' => 0))}}">
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
                            <tr >
                                {{--<th width="" class="text-center">{{viewLanguage('STT')}}</th>--}}
                                <th width="25%">{{viewLanguage('Tên thuộc tính')}}</th>
                                <th width="25%" class="text-center">{{viewLanguage('Tên hồ sơ')}}</th>
                                <th width="20%" class="text-center">{{viewLanguage('Ngày tạo')}}</th>
                                <th width="20%" class="text-center">{{viewLanguage('Ngày cập nhật')}}</th>
                                {{--<th width="10%" class="text-center">{{viewLanguage('Thao tác')}}</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($data) && sizeof($data))
                                @foreach($data as $k=>$item)
                                <tr class="detailView" data-action="{{route('admin.documentEntityAttributeEdit',['id'=>$item['id']])}}">
                                    {{--<td class="text-center">{{$stt + $k + 1}}</td>--}}
                                    <td width="25%">{{$item->name}}</td>
                                    <td width="25%">{{$infor_document_type[$item->document_type_id]}}</td>
                                    <td width="20%">{{$item->created_at}}</td>
                                    <td width="20%">{{$item->updated_at}}</td>
                                    {{--<td width="10%" class="text-center middle" align="center">--}}
                                        {{--@if($is_root || $permission_full || $permission_create)--}}
                                            {{--<a class="editItem" onclick="VM.editItem('{{$item->id}}', WEB_ROOT + '/manager/document_type/ajaxLoad')" title="{{viewLanguage('Sửa')}}">--}}
                                                {{--<i class="fa fa-edit fa-2x"></i>--}}
                                            {{--</a>--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {!! $paging !!}
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