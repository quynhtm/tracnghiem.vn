<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
@extends('admin.AdminLayouts.index')
@section('content')
<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed top_nav" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </li>
            <li class="active">{{$pageAdminTitle}}</li>
        </ul>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <form method="Post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-3">
                                <label for="name"><i>{{viewLanguage('Tên audio')}}</i></label>
                                <input type="text" class="form-control input-sm" id="name_audio_search" name="name_audio" placeholder="{{viewLanguage('Tên audio')}}" @if(isset($search['name_audio']))value="{{$search['name_audio']}}"@endif>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                                <select name="status" id="status_search" class="form-control input-sm">
                                    {!! $optionStatus !!}}
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="status" class="control-label">{{viewLanguage('Mục đích nhắc nợ')}}</label>
                                <select name="remind_type" id="remind_type_search" class="form-control input-sm">
                                    {!! $optionRemindType !!}}
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            @if($is_root || $permission_full || $permission_create)
                                <a class="btn btn-danger btn-sm" href="{{URL::route('admin.reminderDebtEdit',array('id' => 0))}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    {{viewLanguage('Thêm mới')}}
                                </a>
                            @endif
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('search')}}</button>
                        </div>
                    </form>
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr >
                                <th  class="text-center">{{viewLanguage('ID cuộc gọi')}}</th>
                                <th >{{viewLanguage('Tên audio')}}</th>
                                <th >{{viewLanguage('Link audio')}}</th>
                                <th class="text-center">{{viewLanguage('Mô tả audio')}}</th>
                                <th class="text-center">{{viewLanguage('Mục đích nhắc nợ')}}</th>
                                <th class="text-center">{{viewLanguage('Trạng thái')}}</th>
                                <th class="text-center">{{viewLanguage('Ngày tạo')}}</th>
{{--                                <th class="text-center">{{viewLanguage('Thao tác')}}</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr class="detailView" data-action="{{route('admin.reminderDebtEdit',['id'=>$item['id']])}}">
                                    <td class="text-center middle">{{ $stt+$key+1 }}</td>
                                    <td>{{ $item['name_audio'] }}</td>
                                    <td class="text-center">
                                        <audio controls>
                                            <source src="{{URL_IMAGE.$item->link_audio}}" type="audio/ogg">
                                            <source src="{{URL_IMAGE.$item->link_audio}}" type="audio/mpeg">
                                        </audio>
                                    </td>
                                    <td>{{ $item['decscription'] }}</td>
                                    <td>{{ \App\Http\Models\Admin\ReminderDept::$array_remind_type[$item['remind_type']]}}</td>
                                    <td >{{\App\Http\Models\Admin\ReminderDept::$array_status[$item['status']]}}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                    {{--<td>{{ $item['created_at'] }}</td>--}}

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {!! $paging !!}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop