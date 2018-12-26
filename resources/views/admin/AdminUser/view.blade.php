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
            <li class="active">Quản lý người dùng</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    <form method="Post" action="" role="form">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group col-lg-2">
                                <label for="user_name"><i>Tên đăng nhập</i></label>
                                <input type="text" class="form-control input-sm" id="user_name" name="user_name" autocomplete="off" placeholder="Tên đăng nhập" @if(isset($dataSearch['user_name']))value="{{$dataSearch['user_name']}}"@endif>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="user_email"><i>Email</i></label>
                                <input type="text" class="form-control input-sm" id="user_email" name="user_email" autocomplete="off" placeholder="Địa chỉ email" @if(isset($dataSearch['user_email']))value="{{$dataSearch['user_email']}}"@endif>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="user_phone"><i>Di động</i></label>
                                <input type="text" class="form-control input-sm" id="user_phone" name="user_phone" autocomplete="off" placeholder="Số di động" @if(isset($dataSearch['user_phone']))value="{{$dataSearch['user_phone']}}"@endif>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="user_group"><i>Loại quyền</i></label>
                                <select name="role_type" id="role_type" class="form-control input-sm" tabindex="12" data-placeholder="Chọn nhóm quyền">
                                    <option value="0">--- Chọn nhóm quyền ---</option>
                                    {!! $optionRoleType !!}
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="user_group"><i>Auto Loan</i></label>
                                <select name="auto_loan" id="auto_loan" class="form-control input-sm" tabindex="12" data-placeholder="Chọn quyền YCV">
                                    <option value="{{STATUS_DEFAULT}}">--- Chọn quyền YCV ---</option>
                                    {!! $optionAutoLoan !!}
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="user_group"><i>Chức vụ</i></label>
                                <select name="position" id="position" class="form-control input-sm" tabindex="12" data-placeholder="Chức vụ">
                                    {!! $optionPosition !!}
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.user_edit',array('id' => FunctionLib::inputId(0)))}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                            <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                        </div>
                    </form>
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($size >0) Có tổng số <b>{{$size}}</b> tài khoản  @endif </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr class="">
                                <th width="3%" class="text-center">STT</th>
                                <th width="5%" class="text-center">Ảnh</th>
                                <th width="15%">Thông tin User</th>
                                <th width="15%">Thông tin liên hệ</th>
                                <th width="10%" class="text-center">Chức vụ</th>
                                <th width="10%">Phòng ban</th>
                                <th width="10%" class="text-center">Quyền</th>
                                <th width="10%">Thao tác trên YCV</th>
                                <th width="10%" class="text-center">Ngày</th>
                                <th width="10%" class="text-center">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $item)
                                <tr @if($item['user_status'] == \App\Library\AdminFunction\Define::STATUS_BLOCK)class="red bg-danger middle" @else class="middle" @endif>
                                    <td class="text-center middle">{{ $start+$key+1 }}</td>
                                    <td class="text-center middle">
                                        <div  style="width:50px; height: 50px; overflow: hidden">
                                            @if(isset($item['user_image']) && trim($item['user_image']) != '')
                                                <img src="{{env('APP_URL').env('APP_PATH_UPLOAD_MIDDLE').$item['user_image']}}" height="50" width="50"/>
                                            @else
                                                <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/icon/no-profile-image.gif" height="50" width="50"/>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div><b>U: </b><b class="green">{{ $item['user_name'] }}</b></div>
                                        <div><b>N: </b>{{ $item['user_full_name'] }}</div>
                                    </td>
                                    <td>
                                        @if(trim($item['user_phone']) != '')<div><b>Phone: </b>{{ $item['user_phone'] }}</div>@endif
                                        @if(trim($item['user_email']) != '')<div><b>E: </b>{{ $item['user_email'] }}</div>@endif
                                    </td>
                                    <td class="text-center middle">
                                        @if($arrPosition[$item['position']] && $item['position'] > 0){{$arrPosition[$item['position']]}}@endif
                                    </td>
                                    <td>
                                        @if(isset($arrDepartment[$item['user_depart_id']]) && $item['user_depart_id'] > 0){{$arrDepartment[$item['user_depart_id']]}} <br/>@endif
                                        @if(isset($arrUser[$item['user_manager_id']]) && $item['user_manager_id'] > 0)Q.ly: <b>{{$arrUser[$item['user_manager_id']]}}</b>@endif
                                    </td>
                                    <td class="text-center middle">
                                        @if(isset($arrRoleType[$item['role_type']])){{$arrRoleType[$item['role_type']]}}@endif
                                    </td>
                                    <td>
                                        @if(isset($arrAutoLoan[$item['auto_loan']])){{$arrAutoLoan[$item['auto_loan']]}}@endif
                                    </td>
                                    <td class="text-center middle">
                                        @if($item['user_last_login'] != '')
                                            <?php
                                                $today = date('Ymd', time());
                                                $online = date('Ymd', strtotime($item['user_last_login']));
                                                $date_online = date('d-m-Y H:i:s', strtotime($item['user_last_login']));
                                            ?>
                                                @if($today == $online && strtotime($item['user_last_login']) > strtotime($item['user_last_logout']))
                                                    <i class="fa fa-smile-o fa-2x green" aria-hidden="true"></i>
                                                    <div class="green">{{ $date_online }}</div>
                                                @else
                                                    <i class="fa fa-meh-o fa-2x red" aria-hidden="true"></i>
                                                    <div>{{ $date_online }}</div>
                                                @endif
                                        @endif
                                        @if(isset($arrStatus[$item['user_status']]) && $item['user_status'] == STATUS_BLOCK)<br>{{$arrStatus[STATUS_BLOCK]}}@endif
                                    </td>
                                    <td class="text-center middle" align="center">
                                        {{--@if(($is_root || $permission_edit) && $item['user_status'] != \App\Library\AdminFunction\Define::STATUS_BLOCK)
                                            <a href="#" onclick="Admin.getInfoSettingUser('{{FunctionLib::inputId($item['user_id'])}}')" title="Setting item"><i class="fa fa-cog fa-2x"></i></a> &nbsp;&nbsp;&nbsp;
                                        @endif--}}
                                    @if($is_root || $permission_edit)
                                            <a href="{{URL::route('admin.user_edit',array('id' => FunctionLib::inputId($item['user_id'])))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                        @endif
                                        @if(($is_root || $permission_change_pass) && $item['user_status'] != \App\Library\AdminFunction\Define::STATUS_BLOCK)
                                            <a href="{{URL::route('admin.user_change',array('id' => FunctionLib::inputId($item['user_id'])))}}" title="Reset mật khẩu"><i class="fa fa-refresh fa-2x"></i></a>&nbsp;&nbsp;&nbsp;
                                        @endif
                                        @if($is_boss || $permission_remove)
                                            <a href="javascript:void(0)" class="sys_delete_user" data-content="Xóa tài khoản" data-placement="bottom" data-trigger="hover" data-rel="popover" data-url="user/remove/" data-id="{{FunctionLib::inputId($item['user_id'])}}">
                                                <i class="fa fa-trash fa-2x"></i>
                                            </a>
                                        @endif
                                    </td>
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
    </div><!-- /.page-content -->
</div>

<!--Popup anh khac de chen vao noi dung bai viet-->
<div class="modal fade" id="sys_showPopupInfoSetting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Cài đặt người dùng</h4>
            </div>
            <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_district">
            <div class="modal-body" id="sys_show_infor">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('[data-rel=popover]').popover({container: 'body'});
</script>
@stop