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
            <li class="active">Phân quyền theo Role</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info" style="display: none">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-12 text-right">
                            @if($is_root || $permission_full ==1 || $permission_create == 1)
                                <a class="btn btn-danger btn-sm" href="{{URL::route('admin.editRole',array('id' => FunctionLib::inputId(0)))}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    {{FunctionLib::viewLanguage('add')}}
                                </a>
                            @endif
                                {{--<button class="btn btn-warning btn-sm" type="submit" name="submit" value="2"><i class="fa fa-file-excel-o"></i> Xuất Excel</button>--}}
                                <button class="btn btn-primary btn-sm" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{FunctionLib::viewLanguage('search')}}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                @if($data && sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="3%" class="text-center">TT</th>
                            <th width="15%">Role name</th>
                            <th width="75%">List quyền</th>
                            <th width="2%" class="text-center">Order</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr @if($item['role_status'] == STATUS_INT_KHONG)class="red bg-danger middle detailView" @else class="middle detailView" @endif data-action="{{route('admin.editRole',['id' => FunctionLib::inputId($item['role_menu_id'])])}}" data-container="body" data-toggle="popover" data-placement="top" data-title="{{viewLanguage('Thông tin log thao tác')}}" data-html-content="#popover{{$item['role_menu_id']}}">
                                <td class="text-center text-middle">{!! $stt + $key+1 !!}</td>
                                <td>
                                    {!! $item['role_name'] !!}
                                    @if ($item['role_menu_id'])
                                        <div class="hidden popover-html" id="popover{{$item['role_menu_id']}}">
                                            <div class="title">
                                                {{viewLanguage("Mã Role")}}: {{$item['role_menu_id']}}
                                            </div>
                                            <div class="content">
                                                <table>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Người tạo")}}:</strong></td>
                                                        <td>{{$item['user_name_creater']}} ({{$item['created_at']}})</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{viewLanguage("Người cập nhật")}}:</strong></td>
                                                        <td>{{$item['user_name_update']}} ({{$item['updated_at']}})</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <?php
                                        $arrRoleGroup = (trim($item['role_group_permission']) != '') ? explode(',', $item['role_group_permission']):[];
                                    ?>
                                    @if(!empty($arrRoleGroup))
                                        @foreach ($arrRoleGroup as $role_group)
                                            @if(isset($arrGroupUser[$role_group]))
                                                {{$arrGroupUser[$role_group]}},
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center text-middle">{!! $item['role_order'] !!}</td>
                                <td class="text-center text-middle">
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.editRole',array('id' => FunctionLib::inputId($item['role_menu_id'])))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_boss)
                                        {{--<a href="{{URL::route('admin.editRole',array('id' => FunctionLib::inputId($item['role_menu_id']),'action_copy'=>1))}}" title="Copy item"><i class="fa fa-files-o fa-2x"></i></a>--}}
                                        <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['role_menu_id']}},3)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['role_menu_id']}}"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="text-right">
                        {{$paging}}
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