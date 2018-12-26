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
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <form id="frmSearch" method="get" action="" role="form">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <label><i>{{viewLanguage('Tên')}}</i></label>
                                    <input type="text" class="form-control input-sm" name="user_full_name" placeholder="{{viewLanguage('Tên')}}" @if(isset($search['user_full_name']))value="{{$search['user_full_name']}}"@endif>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label><i>{{viewLanguage('Địa chỉ mail')}}</i></label>
                                    <input type="text" class="form-control input-sm" name="user_email" placeholder="{{viewLanguage('Địa chỉ mail')}}" @if(isset($search['user_email']))value="{{$search['user_email']}}"@endif>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="wrap-panel">
                                <div class="inline pull-right">
                                    <span class="btn btn-danger btn-sm savePermisStringee"><i class="fa fa-save"></i> {{viewLanguage('Lưu')}}</span>
                                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> {{viewLanguage('Tìm kiếm')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mgt15 bodyInput">
                    <div class="span clearfix"> @if($total >0) Có tổng số: <b>{{$total}}</b>@endif </div>
                    {{Form::open(array('method' => 'POST', 'role'=>'form', 'class' =>'permissionStringeeCall','files' => false, 'url'=>URL::route('stringee.permissionStringeeCall')))}}
                    <table class="table table-bordered bg-head-table">
                        <thead>
                        <tr>
                            <th width="20%">{{viewLanguage('Tên')}}</th>
                            <th width="10%">{{viewLanguage('Địa Chỉ Email')}}</th>
                            <th width="10%">{{viewLanguage('Ngày hoạt động')}}</th>
                            <th width="15%" class="text-center">{{viewLanguage('Ngày ngừng hoạt động')}}</th>
                            <th width="10%" class="text-center">{{viewLanguage('Thống kê cuộc nghe gọi')}}</th>
                            <th width="8%" class="text-center">{{viewLanguage('Gọi đi')}}<input type="checkbox" name="checkAllCall" id="checkAllCall"></th>
                            <th width="8%" class="text-center">{{viewLanguage('Gọi đến')}}<input type="checkbox" name="checkAllCallMe" id="checkAllCallMe"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($data) && sizeof($data) > 0)
                                @foreach($data as $item)
                                <tr>
                                    <td>
                                        {{$item->user_full_name}}
                                        <input type="hidden" name="username[{{$item->user_id}}]" value="{{$item->user_full_name}}">
                                        <input type="hidden" name="usermail[{{$item->user_id}}]" value="{{$item->user_email}}">
                                    </td>
                                    <td>{{$item->user_email}}</td>
                                    <td>
                                        @if(isset($dataPermissionStringee[$item->user_id]['active_created']) && (int)$dataPermissionStringee[$item->user_id]['active_created'] > 0)
                                            {{date('d/m/Y H:i', $dataPermissionStringee[$item->user_id]['active_created'])}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($dataPermissionStringee[$item->user_id]['disable_created']) && (int)$dataPermissionStringee[$item->user_id]['disable_created'] > 0)
                                            {{date('d/m/Y H:i', $dataPermissionStringee[$item->user_id]['disable_created'])}}
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="checkbox" name="permistion[{{$item->user_id}}]" class="checkItemCall"
                                        @if(isset($dataPermissionStringee[$item->user_id]['status_call_stringee']) && $dataPermissionStringee[$item->user_id]['status_call_stringee'] == STATUS_SHOW) checked="checked" @endif
                                        value="1">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="permistion_me[{{$item->user_id}}]" class="checkItemCallMe"
                                        @if(isset($dataPermissionStringee[$item->user_id]['status_call_stringee_me']) && $dataPermissionStringee[$item->user_id]['status_call_stringee_me'] == STATUS_SHOW) checked="checked" @endif
                                        value="1">
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ Form::close() }}
                    <div class="text-right">
                        {!! $paging !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop